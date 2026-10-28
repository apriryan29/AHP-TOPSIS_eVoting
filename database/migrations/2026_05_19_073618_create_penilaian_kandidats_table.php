<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_kandidats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kandidat_id')
                ->constrained('kandidats')
                ->cascadeOnDelete();

            $table->foreignId('validasi_kandidat_id')
                ->constrained('validasi_kandidats')
                ->cascadeOnDelete();

            $table->integer('nilai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_kandidats');
    }
};