<?php

namespace App\Http\Controllers;

use App\Models\MenuCatering;
use App\Models\Paket;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class CateringController extends Controller
{
    public function index()
    {
        $catering = MenuCatering::simplePaginate(10);
        $paket = Paket::all();
        return view('pawonbydudy.admin.menu_catering.index', compact( 'catering', 'paket'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'id_paket' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto')->getPathname();
    
            $manager = new ImageManager(new Driver());
    
            $image = $manager->read($file);
    
            $image->scale(width: 600, height: 600);
    
            // Save as WebP
            $filename = 'menu_foto/' . uniqid() . '.webp';
            $webpData = $image->toWebp(quality: 80);
    
            Storage::disk('public')->put($filename, $webpData);
    
            $validatedData['foto'] = $filename;
        }

        MenuCatering::create($validatedData);
        return redirect()->route('pawonbydudy_catering.catering.index')->with('success', 'Data berhasil tersimpan');
    }

    public function update(Request $request, $id)
    {
        $menucatering = MenuCatering::where('id_catering', $id)->firstOrFail();

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
            'status' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
    
        if ($request->hasFile('foto')) {
            $file = $request->file('foto')->getPathname();
    
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->scale(width: 600, height: 600);
    
            $filename = 'menu_foto/' . uniqid() . '.webp';
            $webpData = $image->toWebp(quality: 80);
    
            Storage::disk('public')->put($filename, $webpData);
            $validatedData['foto'] = $filename;
    
            // Optional: delete old image
            if ($menucatering->foto && Storage::disk('public')->exists($menucatering->foto)) {
                Storage::disk('public')->delete($menucatering->foto);
            }
        }
    
        $menucatering->update($validatedData);
    
        return redirect()->route('pawonbydudy_catering.catering.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $catering = MenuCatering::findOrFail($id);
    
        if ($catering->foto && Storage::disk('public')->exists($catering->foto)) {
            Storage::disk('public')->delete($catering->foto);
        }
        
        $catering->delete();
    
        return redirect()->route('pawonbydudy_catering.catering.index')
            ->with('success', 'Data berhasil dihapus');
    }     
}
