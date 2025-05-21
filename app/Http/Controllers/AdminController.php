<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::simplePaginate(5);
        return view('pawonbydudy.admin.admins.index', compact( 'admin'));        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
            'status' => 'required',
        ]);

        // $validatedData['password'];
        Admin::create($validatedData);
        return redirect()->route('pawonbydudy_admin.admin.index')->with('success', 'Data berhasil tersimpan');        
    }

    public function update(Request $request, $id)
    {
        // Find the admin record by ID
        $admin = Admin::findOrFail($id);
    
        // Validate the incoming request
        $request->validate([
            'email' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'role_admin' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
    
        // Update the admin record
        $admin->email = $request->input('email');
        $admin->username = $request->input('username');
        $admin->role_admin = $request->input('role_admin');
        $admin->status = $request->input('status');
    
        $admin->save();
    
        // Redirect back or to a specific page with a success message
        return redirect()->route('pawonbydudy_admin.admin.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('pawonbydudy_admin.admin.index')->with('success', 'Data berhasil dihapus');
    }    
}
