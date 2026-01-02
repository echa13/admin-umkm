<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->bigIncrements('pesanan_id');
            $table->string('nomor_pesanan', 50)->unique();
            $table->unsignedBigInteger('warga_id');
            $table->decimal('total', 12, 2);
            $table->enum('status', ['pending','dibayar','dikirim','selesai','dibatalkan'])->default('pending');
            $table->string('alamat_kirim',255);
            $table->string('rt',5)->nullable();
            $table->string('rw',5)->nullable();
            $table->string('metode_bayar',50);
            $table->timestamps();

            // FK ke warga
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
