<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanProduk extends Model
{
    use HasFactory;

    protected $table = 'ulasan_produk';
    protected $primaryKey = 'ulasan_id';

    protected $fillable = [
        'produk_id',
        'warga_id',
        'rating',
        'komentar',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
