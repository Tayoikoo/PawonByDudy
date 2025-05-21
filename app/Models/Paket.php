<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    public $timestamps = false;
    protected $table = "paket";
    protected $primaryKey = 'id_paket';
    protected $guarded = 'id_paket';

    protected $fillable = [
        'nama_paket'
    ];    

    public function menu_catering()
    {
        return $this->hasMany(MenuCatering::class, 'id_paket', 'id_paket');
    }    
}
