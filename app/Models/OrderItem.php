<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = true;
    protected $table = "order_item";
    protected $guarded = ['id_item'];

    // Relasi ke model MenuCatering
    public function menu_catering()
    {
        return $this->belongsTo(MenuCatering::class, 'id_catering', 'id_catering');
    }
}
