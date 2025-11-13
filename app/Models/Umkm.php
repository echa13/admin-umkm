<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm'; // Nama tabel

    protected $primaryKey = 'umkm_id'; // Primary key tabel

    // Jika primary key bukan auto increment 'id', set ini jadi true
    public $incrementing = true;

    // Jika primary key bukan tipe integer, tambahkan:
    // protected $keyType = 'int';

    protected $fillable = [
        'nama_usaha',
        'pemilik_warga_id',
        'alamat',
        'rt',
        'rw',
        'kategori',
        'kontak',
        'deskripsi',
    ];

    /**
     * Relasi ke model Warga
     * Setiap UMKM dimiliki oleh satu warga
     */
    public function pemilik()
    {
        return $this->belongsTo(Warga::class, 'pemilik_warga_id', 'warga_id');
    }
}
