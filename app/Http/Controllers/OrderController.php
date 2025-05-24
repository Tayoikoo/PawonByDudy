<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Auth;
use Illuminate\Http\Request;

use App\Models\MenuCatering;
use App\Models\Paket;
use App\Models\User;
use App\Models\Order;

class OrderController extends Controller
{
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
    
    public function decreaseQuantity(Request $request, $id_item)
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
}
