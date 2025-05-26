<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = "order";
    protected $guarded = ['id_order'];
    protected $primaryKey = 'id_order';


    public function orderItems() 
    { 
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order'); 
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pengirim()
    {
        return $this->belongsTo(Pengirim::class, 'id_pengirim', 'id_pengirim');
    }    
}
