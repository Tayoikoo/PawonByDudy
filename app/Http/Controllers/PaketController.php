<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $packet = Paket::simplePaginate(5);
        return view('pawonbydudy.admin.paket.index', compact( 'packet'));        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_paket' => 'required'
        ]);

        // $validatedData['password'];
        Paket::create($validatedData);
        return redirect()->route('pawonbydudy_paket.paket.index')->with('success', 'Data berhasil tersimpan');        
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required'
        ]);

        $paket->nama_paket = $request->input('nama_paket');
        $paket->save();

        return redirect()->route('pawonbydudy_paket.paket.index')->with('success', 'Data Berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();
        return redirect()->route('pawonbydudy_paket.paket.index')->with('success', 'Data berhasil dihapus');
    }    
}
