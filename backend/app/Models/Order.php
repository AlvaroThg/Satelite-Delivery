<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'store_id',
        'driver_id',
        'subtotal',
        'delivery_fee',
        'total',
        'lat',
        'lng',
        'reference_text',
        'status',
    ];

    protected $casts = [
        'subtotal'     => 'float',
        'delivery_fee' => 'float',
        'total'        => 'float',
        'lat'          => 'float',
        'lng'          => 'float',
    ];

    // ─── Relaciones ───────────────────────────────────────────────
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
