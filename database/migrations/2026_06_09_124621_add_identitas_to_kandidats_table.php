<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->string('asal_komisariat')->after('nama');
            $table->string('tahun_dad', 4)->after('asal_komisariat');
            $table->string('nia')->after('tahun_dad');
        });
    }

    public function down(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropColumn([
                'asal_komisariat',
                'tahun_dad',
                'nia',
            ]);
        });
    }
};
