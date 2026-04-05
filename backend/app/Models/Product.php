<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'description',
        'price',
        'image_url',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    // ─── Relaciones ───────────────────────────────────────────────
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
