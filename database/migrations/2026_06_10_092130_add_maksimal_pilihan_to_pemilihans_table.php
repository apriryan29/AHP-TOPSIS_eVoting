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
        Schema::table('pemilihans', function (Blueprint $table) {
            $table->unsignedInteger('maksimal_pilihan')
                ->default(13)
                ->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemilihans', function (Blueprint $table) {
            $table->dropColumn('maksimal_pilihan');
        });
    }
};