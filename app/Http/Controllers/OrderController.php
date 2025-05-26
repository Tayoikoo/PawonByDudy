<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Auth;
use Illuminate\Http\Request;

use App\Models\MenuCatering;
use App\Models\Paket;
use App\Models\User;
use App\Models\Order;
use Midtrans\Snap; 
use Midtrans\Config;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {    
        $orders = Order::where('status', 'paid')
            ->orderBy('tanggal_pemesanan', 'desc')
            ->get();

        foreach ($orders as $order) {
            $order->load('orderItems.menu_catering');
        }

        return view('pawonbydudy.admin.order.index', compact('orders'));        
    }

    public function addToCheckout($id)
    {
        $user = Auth::guard('web')->user();
    
        if (!$user) {
            return redirect()->route('pawonbydudy.showlogin')->with('error', 'Harap login akun lebih dahulu!');
        }
    
        $menuCatering = MenuCatering::where('id_catering', $id)->firstOrFail();
    
        $order = Order::firstOrCreate(
            [
                'id_user' => $user->id_user,
                'status' => 'pending',
                'metode_pembayaran' => '',                
            ],
            ['total_harga' => 0]
        );
    
        $orderItem = OrderItem::firstOrCreate(
            ['id_order' => $order->id_order, 
            'id_catering' => $menuCatering->id_catering,
        ], 
            ['jumlah' => 1, 'harga' => $menuCatering->harga]
        );
    
        if (!$orderItem->wasRecentlyCreated) {
            $orderItem->jumlah++;
            $orderItem->save();
        }
    
        $order->total_harga += $menuCatering->harga;
        $order->save();
    
        // return dd($order);
        return redirect()->route('pawonbydudy.checkout')->with('success', 'Berhasil dimasukkan ke keranjang!');
    }

    public function deleteFromCheckout($id_item)
    {
        $user = Auth::guard('web')->user();
    
        if (!$user) {
            return redirect()->route('pawonbydudy.showlogin')->with('error', 'Harap login terlebih dahulu!');
        }
    
        $orderItem = OrderItem::findOrFail($id_item);
    
        // Pastikan item memang milik user yang sedang login
        if ($orderItem->order->id_user !== $user->id_user) {
            abort(403, 'Unauthorized action.');
        }
    
        // Kurangi total harga di order
        $order = $orderItem->order;
        $order->total_harga -= $orderItem->harga * $orderItem->jumlah;
        $order->save();
    
        // Hapus item
        $orderItem->delete();
    
        return redirect()->back()->with('success', 'Item berhasil dihapus dari checkout.');
    }


    public function increaseQuantity($id_item)
    {
        $user = Auth::guard('web')->user();
    
        $orderItem = OrderItem::findOrFail($id_item);
        if ($orderItem->order->id_user !== $user->id_user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $orderItem->jumlah += 1;
        $orderItem->save();
    
        $order = $orderItem->order;
        $order->total_harga += $orderItem->harga;
        $order->save();
    
        return response()->json([
            'success' => true,
            'jumlah' => $orderItem->jumlah,
            'total_harga' => number_format($order->total_harga, 0, ',', '.')
        ]);
    }
    
    public function decreaseQuantity($id_item)
    {
        $user = Auth::guard('web')->user();
    
        $orderItem = OrderItem::findOrFail($id_item);
        if ($orderItem->order->id_user !== $user->id_user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        if ($orderItem->jumlah > 1) {
            $orderItem->jumlah -= 1;
            $orderItem->save();
    
            $order = $orderItem->order;
            $order->total_harga -= $orderItem->harga;
            $order->save();
    
            return response()->json([
                'success' => true,
                'jumlah' => $orderItem->jumlah,
                'total_harga' => number_format($order->total_harga, 0, ',', '.')
            ]);
        }
    
        return response()->json(['error' => 'Minimum quantity is 1'], 400);
    }

    public function updateJumlah(Request $request, $id)
    {
        $jumlah = max((int)$request->input('jumlah'), 1);
    
        $item = OrderItem::findOrFail($id);
        $item->jumlah = $jumlah;
        $item->save();
    
        // Update total harga of the order
        $order = $item->order;
        $order->total_harga = $order->orderItems->sum(function ($i) {
            return $i->jumlah * ($i->menu_catering->harga ?? 0);
        });
        $order->save();
    
        return response()->json([
            'success' => true,
            'jumlah' => $item->jumlah,
            'total_harga' => number_format($order->total_harga ?? 0, 0, ',', '.')
        ]);
    }

    public function doPayment(Request $request, $id)
    {
        // Step 1: Update input user ke database
        $validated = $request->validate([
            'alamat'            => 'required|string|max:255',
            'pos'               => 'required|string|max:10',
            'tanggal_pemesanan' => 'required|date',
        ]);

        $getOrder = Order::findOrFail($id);
        $inputDate = $validated['tanggal_pemesanan'];
        $currentTime = Carbon::now()->format('H:i:s');
        
        // Combine into full datetime: '2025-05-26 09:45:12'
        $datetime = Carbon::parse($inputDate . ' ' . $currentTime);        

        $getOrder->alamat               = $validated['alamat'];
        $getOrder->pos                  = $validated['pos'];
        $getOrder->tanggal_pemesanan    = $datetime;
        $getOrder->save();

        // Step 2 redirect ke halaman pembayaran midtrans
        $customer = Auth::guard('web')->user();
    
        $order = Order::where('id_user', $customer->id_user)
                      ->where('status', 'pending')
                      ->first();
    
        if ($order) {
            $order->load('orderItems.menu_catering');
        }
    
        // Hitung total harga dari item    
        $grossAmount = $order->total_harga + 0.01;
    
        // Konfigurasi Midtrans
        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey    = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized  = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds        = env('MIDTRANS_IS_JDS');
    
        // Buat ID pesanan unik
        $orderId = $order->id_order . '-' . time();
    
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $customer->username,
                'email'      => $customer->email,
                'phone'      => $customer->hp,
            ],
        ];
    
        $snapToken = Snap::getSnapToken($params);
   
        // return dd($snapToken);
        return view('pawonbydudy.catering.payment.index', [
            'snapToken' => $snapToken,
            'order' => $order,
        ]);
    }   
    
   public function callback(Request $request) 
    { 
        $serverKey = env('MIDTRANS_SERVER_KEY'); 
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey); 
        if ($hashed == $request->signature_key) { 
            $order = Order::find($request->order_id); 
            if ($order) { 
                $order->update(['status' => 'Dibayar']); 
            } 
        } 
    }
    public function onPaymentFinish(Request $request, $id)
    {
        $paymentType = $request->query('payment_type');
        $order = Order::findOrFail($id);

        $order->metode_pembayaran = $paymentType;
        $order->status = 'paid';
        $order->save();
        return redirect()->route('pawonbydudy.history_order')->with('success', 'Pembayaran telah berhasil!');
    }

    public function downloadInvoice($id_order)
    {
        $order = Order::findOrFail($id_order);
    
        $user = Auth::guard('web')->user();
    
        if (!$user) {
            return redirect()->route('pawonbydudy.showlogin')->with('error', 'Harap login akun lebih dahulu!');
        }
    
        $order = Order::where('id_user', $user->id_user)
        ->where('status', 'paid')
        ->where('id_order', $id_order)
        ->first();
    
        $order->load('orderItems.menu_catering');

        $pdf = PDF::loadView('pawonbydudy.catering.history.invoice', compact('order'))
                    ->setPaper('a4', 'landscape');
    
        return $pdf->download('invoice_order_'.$order->id_order.'.pdf');
    }
}
