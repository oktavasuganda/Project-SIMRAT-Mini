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
        Schema::create('mail_categories', function (Blueprint $table) {
            $table->id();
            // Kolom untuk nama Kategori Surat
            $table->string('name')->unique();
            // Kolom untuk deskripsi Kategori Surat (bisa null)
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_categories');
    }
};
