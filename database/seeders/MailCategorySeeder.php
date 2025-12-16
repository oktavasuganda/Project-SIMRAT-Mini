<?php

namespace Database\Seeders;

use App\Models\MailCategory; // Pastikan Anda mengimpor Model MailCategory
use Illuminate\Database\Seeder;

class MailCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Surat Pemberitahuan'],
            ['name' => 'Surat Perintah'],
            ['name' => 'Surat Permintaan/Permohonan'],
            ['name' => 'Surat Susulan'],
            ['name' => 'Surat Peringatan/Teguran'],
            ['name' => 'Surat Panggilan'],
            ['name' => 'Surat Pengantar'],
            ['name' => 'Surat Keputusan'],
            ['name' => 'Surat Laporan'],
            ['name' => 'Surat Perjanjian'],
            ['name' => 'Surat Penawaran'],
            ['name' => 'Surat Undangan'],
            ['name' => 'Lain-lain'],
            ['name' => 'Surat Balasan'],
            ['name' => 'Surat Izin'],
            ['name' => 'Surat Lamaran'],
            ['name' => 'Surat Tugas'],
            ['name' => 'Berita Acara'],
        ];

        // Memasukkan data ke tabel mail_categories
        foreach ($categories as $category) {
            // Kita bisa menambahkan kolom 'description' di sini jika ada data deskripsi.
            // Jika tidak ada, biarkan saja, karena di Migration kita sudah set nullable.
            MailCategory::create($category);
        }

        // Atau menggunakan insert massal jika Anda ingin lebih cepat dan tidak memerlukan timestamps
        /*
        MailCategory::insert($categories);
        */
    }
}
