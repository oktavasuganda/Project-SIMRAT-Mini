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
        Schema::create('outboxes', function (Blueprint $table) {
            $table->id(); // 1. id

            // Kolom dengan index unik
            $table->string('agenda_number', 255)->unique(); // 2. agenda_number
            $table->string('mail_number', 255)->unique();  // 3. mail_number

            // Kolom Data Utama Surat
            $table->date('mail_date');          // 4. mail_date
            $table->string('intended_for', 255); // 5. intended_for (Tujuan surat keluar, di sini wajib)
            $table->string('subject', 255);     // 6. subject
            $table->text('summary')->nullable(); // 7. summary (ringkasan, bisa null)
            $table->string('file_path', 255)->nullable(); // 8. file_path (path file attachment, bisa null)

            // Foreign Key (Relasi ke tabel mail_categories)
            // 9. mail_category_id
            $table->foreignId('mail_category_id')->constrained('mail_categories')->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outboxes');
    }
};
