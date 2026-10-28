<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vote_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vote_id')
                ->constrained('votes')
                ->cascadeOnDelete();

            $table->foreignId('candidate_id')
                ->constrained('kandidats')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['vote_id', 'candidate_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vote_details');
    }
};