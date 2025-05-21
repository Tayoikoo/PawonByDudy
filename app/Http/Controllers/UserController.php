<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::paginate(5);
        return view('pawonbydudy.admin.users.index', compact( 'user'));        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'hp' => 'required|string|max:13'
        ]);

        // $validatedData['password'];
        User::create($validatedData);
        return redirect()->route('pawonbydudy_user.user.index')->with('success', 'Data berhasil tersimpan');        
    }

    public function update(Request $request, $id)
    {
        // Find the admin record by ID
        $user = User::findOrFail($id);
    
        // Validate the incoming request
        $request->validate([
            'email' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'hp' => 'required|string|max:13'
        ]);
    
        // Update the admin record
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->hp = $request->input('hp');
    
        $user->save();
    
        // Redirect back or to a specific page with a success message
        return redirect()->route('pawonbydudy_user.user.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->route('pawonbydudy_user.user.index')->with('success', 'Data berhasil dihapus');
    }    
}
