<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->increments('umkm_id'); // Primary Key
            $table->string('nama_usaha', 150);
            $table->unsignedBigInteger('pemilik_warga_id');
            $table->string('alamat', 255);
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('kategori', 100);
            $table->string('kontak', 20)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('pemilik_warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
