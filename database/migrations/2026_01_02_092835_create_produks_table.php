<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('produk_id');            // PK
            $table->unsignedInteger('umkm_id'); // FK ke umkm_id
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->integer('stok');
            $table->enum('status', ['tersedia', 'kosong'])->default('tersedia');
            $table->timestamps();

            // FK manual karena PK bukan 'id'
            $table->foreign('umkm_id')->references('umkm_id')->on('umkm')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
