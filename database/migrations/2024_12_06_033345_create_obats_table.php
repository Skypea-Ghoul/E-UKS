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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->string('fungsi_obat');
            $table->string('jumlah_obat');
            $table->string('gambar_obat');
            $table->string('jenis_obat')->nullable();
            $table->string('anjuran')->nullable();
            $table->string('tipe_obat')->nullable();
            $table->integer('jumlah_dipakai')->nullable();
            $table->enum('status_obat', ['Tersedia', 'Tidak Tersedia']);
            $table->date('kadaluarsa');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
