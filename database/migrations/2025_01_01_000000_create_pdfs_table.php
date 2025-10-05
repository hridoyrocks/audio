<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('pdf_file')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pdfs');
    }
};
