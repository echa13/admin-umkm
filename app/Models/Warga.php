<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang terkait dengan model ini
    protected $table = 'warga';

    // Menentukan Primary Key kustom
    protected $primaryKey = 'warga_id';

    // Mengizinkan Primary Key untuk di-increment
    public $incrementing = true;

    public $timestamps = false;

    // Menentukan tipe data Primary Key
    protected $keyType = 'int';

    // Kolom-kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'no_ktp',
        'nama',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'telp',
        'email',
    ];

    /**
     * Casting atribut
     * Digunakan untuk mengonversi kolom database ke tipe PHP tertentu
     */
    protected $casts = [
        // Jika perlu casting khusus, tambahkan di sini
        // 'is_active' => 'boolean',
    ];

    public function umkm()
    {
        return $this->hasMany(Umkm::class, 'pemilik_warga_id', 'warga_id');
    }
}
