<?php

namespace App\Http\Controllers;

use App\Models\Pengirim;
use Illuminate\Http\Request;

class PengirimController extends Controller
{
    public function index()
    {
        $pengirim = Pengirim::simplePaginate(5);
        return view('pawonbydudy.admin.pengirim.index', compact( 'pengirim'));        
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pengirim' => 'required',
            'nomor_telepon' => 'required'
        ]);

        Pengirim::create($validatedData);
        return redirect()->route('pawonbydudy_pengirim.pengirim.index')->with('success', 'Data berhasil tersimpan');        
    }

    public function update(Request $request, $id)
    {
        $pengirim = Pengirim::findOrFail($id);

        $request->validate([
            'nama_pengirim' => 'required',
            'nomor_telepon' => 'required'
        ]);

        $pengirim->nama_pengirim = $request->input('nama_pengirim');
        $pengirim->nomor_telepon = $request->input('nomor_telepon');
        $pengirim->save();

        return redirect()->route('pawonbydudy_pengirim.pengirim.index')->with('success', 'Data Berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $pengirim = Pengirim::findOrFail($id);
        $pengirim->delete();
        return redirect()->route('pawonbydudy_pengirim.pengirim.index')->with('success', 'Data berhasil dihapus');
    }        
}
