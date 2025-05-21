<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\MenuCatering;
use App\Models\Paket;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::insert([
            [
                'email' => 'admin@test.com',
                'username' => 'Lukopa',
                'password' => Hash::make('omg123'),
                'role_admin' => '2',
                'status' => 1,
            ],        
        ]);
        // Seed Paket table
        Paket::insert([
            ['id_paket' => 1, 'nama_paket' => 'Paket Box'],
            ['id_paket' => 2, 'nama_paket' => 'Paket Rice Bowl'],
            ['id_paket' => 3, 'nama_paket' => 'Paket Nasi Kuning'],
        ]);

        // // Seed MenuCatering table
        // MenuCatering::insert([
        //     [
        //         'id_catering' => 1,
        //         'nama' => 'Paket A',
        //         'deskripsi' => 'Ayam, Bebek, Kentang',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 1
        //     ],
        //     [
        //         'id_catering' => 2,
        //         'nama' => 'Paket B',
        //         'deskripsi' => 'Kentang',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 1
        //     ],
        //     [
        //         'id_catering' => 3,
        //         'nama' => 'Paket C',
        //         'deskripsi' => 'Kangkung',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 1
        //     ],
        //     [
        //         'id_catering' => 4,
        //         'nama' => 'Rice Bowl Ayam',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 2
        //     ],
        //     [
        //         'id_catering' => 5,
        //         'nama' => 'Rice Bowl Daging',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 2
        //     ],
        //     [
        //         'id_catering' => 6,
        //         'nama' => 'Rice Bowl Telur',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 2
        //     ],
        //     [
        //         'id_catering' => 7,
        //         'nama' => 'Rice Bowl Sayur',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 2
        //     ],
        //     [
        //         'id_catering' => 8,
        //         'nama' => 'Nasi Kuning Box',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 3
        //     ],
        //     [
        //         'id_catering' => 9,
        //         'nama' => 'Nasi Bento Anak',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 3
        //     ],
        //     [
        //         'id_catering' => 10,
        //         'nama' => 'Nasi Tumpeng Mini',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 3
        //     ],
        //     [
        //         'id_catering' => 11,
        //         'nama' => 'Nasi Tumpeng Besar',
        //         'deskripsi' => '',
        //         'harga' => 10000,
        //         'foto' => '',
        //         'id_paket' => 3
        //     ],            
        // ]);
    }
}
