<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengirim extends Model
{
    public $timestamps = false;
    protected $table = "pengirim";
    protected $guarded = ['id_pengirim'];
    protected $primaryKey = 'id_pengirim';

}
