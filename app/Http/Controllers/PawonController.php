<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\MenuCatering;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Paket;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class PawonController extends Controller
{
    public function index()
    {
        $packet = Paket::with('menu_catering')->get();
        return view('pawonbydudy.index', compact('packet'));
    }

    public function indexAdmin()
    {
        return view('pawonbydudy.admin.index');
    }    

    public function getCheckout()
    {
        $user = Auth::guard('web')->user();
    
        if (!$user) {
            return redirect()->route('pawonbydudy.showlogin')->with('error', 'Harap login akun lebih dahulu!');
        }
    
        $order = Order::where('id_user', $user->id_user)
        ->where('status', 'pending')->first();
    
        if (!$order) {
            return redirect()->route('pawonbydudy.index')->with('error', 'Anda belum memesan menu!');
        }
        $order->load('orderItems.menu_catering'); 
        return view('pawonbydudy.checkout.index', compact('order'));
    }
    

    public function showKategori($id_paket)
    {
        $menuCatering = MenuCatering::where('id_paket', $id_paket)
            ->where('status', 1);
    
        $packet = Paket::where('id_paket', $id_paket)
            ->firstOrFail();
    
        return view('pawonbydudy.catering.list_paket.showpaket', compact('menuCatering', 'packet'));
        // return dd($paket);
    }
    
    public function showInfo($id_catering)
    {
        $menuCatering = MenuCatering::where('id_catering', $id_catering)
        ->where('status', 1)
        ->first();
    
        return view('pawonbydudy.catering.show_menu.index', compact('menuCatering'));
        // dd($menuCatering);
    }
    
    public function getHistoryOrder()
    {
        $user = Auth::guard('web')->user();
    
        if (!$user) {
            return redirect()->route('pawonbydudy.showlogin')->with('error', 'Harap login akun lebih dahulu!');
        }
    
        $orders = Order::where('id_user', $user->id_user)
            ->where('status', 'paid')
            ->orderBy('tanggal_pemesanan', 'desc')
            ->get();

        foreach ($orders as $order) {
            $order->load('orderItems.menu_catering');
        }

        return view('pawonbydudy.catering.history.index', compact('orders'));
    }

    // Admin Login
    public function backendAccount($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();
        return view('pawonbydudy.users.index', compact('user'));
    }

    public function showLogin()
    {
        return view('pawonbydudy.account');
    }   

    public function updateAccount(Request $request, $id_user)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'phone' => 'required|digits_between:10,15',
        ]);
    
        $user = User::where('id_user', $id_user)->firstOrFail();
    
        $user->username = $request->input('username');
        $user->hp = $request->input('phone');
        $user->save();
    
        return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
    }    

    public function onLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('pawonbydudy.index');
        }
    
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('pawonbydudy.index');
        }
    
        return back()->with('error', 'Email/Username atau Password salah');
    }

    public function onRegister(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hp' => ''
        ]);
        
        Auth::guard('web')->login($user);
        return redirect()->route('pawonbydudy.index');
        
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        return redirect()->route('pawonbydudy.index');
    }   
}
