<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perbandingan_kriterias', function (Blueprint $table) {

            $table->id();

            $table->foreignId('kriteria_1_id')
                ->constrained('validasi_kandidats')
                ->cascadeOnDelete();

            $table->foreignId('kriteria_2_id')
                ->constrained('validasi_kandidats')
                ->cascadeOnDelete();

            $table->double('nilai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perbandingan_kriterias');
    }
};