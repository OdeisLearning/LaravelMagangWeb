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
        Schema::create('keterangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained(
                table:'kelas',
                indexName:'Keterangan_kelas_id'
            );
            $table->foreignId('mahasiswa_id')->constrained(
                table:'mahasiswa',
                indexName:'Keterangan_Mahasiswa_id'
            );
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterangan');
    }
};
