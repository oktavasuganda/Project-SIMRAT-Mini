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
        Schema::create('inboxes', function (Blueprint $table) {
            $table->id(); // 1. id

            // Kolom dengan index unik (Unique Keys)
            $table->string('agenda_number', 255)->unique(); // 2. agenda_number
            $table->string('mail_number', 255)->unique();  // 3. mail_number

            // Kolom Data Utama Surat
            $table->date('mail_date')->nullable();          // 4. mail_date
            $table->date('received_date')->nullable();      // 5. received_date
            $table->string('sender', 255)->nullable();      // 6. sender
            $table->string('intended_for', 255)->nullable(); // 7. intended_for (dibuat nullable, asumsi tidak selalu ada)
            $table->string('subject', 255)->nullable();     // 8. subject
            $table->text('summary')->nullable(); // 9. summary (dibuat nullable)
            $table->string('file_path', 255)->nullable(); // 10. file_path (path file attachment, dibuat nullable)

            // Foreign Key (Relasi ke tabel mail_categories)
            // 11. mail_category_id
            // Pastikan tipe data bigInteger karena 'id' di tabel categories adalah bigint
            $table->foreignId('mail_category_id')->constrained('mail_categories')->onDelete('cascade');

            $table->timestamps(); // 12. created_at & 13. updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inboxes');
    }
};
