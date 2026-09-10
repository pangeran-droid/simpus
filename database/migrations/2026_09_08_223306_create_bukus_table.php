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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 20)->unique();
            $table->string('judul', 255);
            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('penulis', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->string('isbn', 20)->nullable()->unique();
            $table->unsignedInteger('stok')->default(0);
            $table->string('rak', 50)->nullable();
            $table->string('cover')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
