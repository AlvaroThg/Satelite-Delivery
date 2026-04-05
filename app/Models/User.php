<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ─── Relaciones ───────────────────────────────────────────────
    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function ordersAsClient()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function ordersAsDriver()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }
}
