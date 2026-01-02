<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan_produk', function (Blueprint $table) {
            $table->bigIncrements('ulasan_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('warga_id');
            $table->tinyInteger('rating'); // misal 1-5
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('produk_id')->references('produk_id')->on('produks')->onDelete('cascade');
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan_produk');
    }
};
