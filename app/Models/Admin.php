<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $guarded = 'admin';
    public $timestamps = false;

    protected $fillable = [
        'email', 'username', 'password', 'role_admin', 'status'
    ];

    protected $hidden = ['password'];
}
