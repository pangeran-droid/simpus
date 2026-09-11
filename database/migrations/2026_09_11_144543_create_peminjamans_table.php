<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 30)->unique();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('buku_id')
                ->constrained('bukus')
                ->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->date('tanggal_realisasi_kembali')->nullable();
            $table->enum('status', [
                'dipinjam',
                'kembali',
                'terlambat'
            ])->default('dipinjam');
            $table->integer('denda')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
