<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    protected $table = "order";
    protected $guarded = ['id_order'];

    public function pengirim()
    {
        return $this->belongsTo(Pengirim::class, 'id_pengirim', 'id_pengirim');
    }    
}
