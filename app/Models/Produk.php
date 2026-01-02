<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'umkm_id', 'nama_produk', 'deskripsi', 'harga', 'stok', 'status'
    ];

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

    // Relasi ke media (manual, sesuai tabel media kamu)
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id')
                    ->where('ref_table', 'produk')
                    ->orderBy('sort_order');
    }
}
