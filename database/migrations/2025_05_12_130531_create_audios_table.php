<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('audio_file')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('play_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audios');
    }
};