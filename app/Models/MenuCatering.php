<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCatering extends Model
{
    public $timestamps = false;
    protected $table = "menu_catering";
    protected $guarded = ['id_catering'];
    protected $primaryKey = 'id_catering';

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id_paket');
    }
}
