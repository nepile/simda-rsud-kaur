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
        Schema::create('permintaan', function (Blueprint $table) {
            $table->id('permintaan_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('jenis_permintaan', ['dinas', 'izin', 'cuti']);
            $table->string('keperluan')->nullable();
            $table->string('tanggal_awal');
            $table->string('tanggal_akhir');
            $table->string('keterangan')->nullable();
            $table->string('surat_dinas')->nullable();
            $table->string('bukti_izin')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};
