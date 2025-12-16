<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\MailCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InboxController extends Controller
{
    /**
     * Menampilkan daftar data Surat Masuk dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Ambil input pencarian
        $search = $request->input('search');

        // Mulai query
        $inboxes = Inbox::with('category');

        // Jika ada input pencarian, terapkan filter
        if ($search) {
            $inboxes->where(function ($query) use ($search) {
                // Cari di beberapa kolom utama: Nomor Agenda, Nomor Surat, Pengirim, atau Subjek
                $query->where('agenda_number', 'LIKE', "%{$search}%")
                    ->orWhere('mail_number', 'LIKE', "%{$search}%")
                    ->orWhere('sender', 'LIKE', "%{$search}%")
                    ->orWhere('subject', 'LIKE', "%{$search}%");
            });

            // Opsional: Cari berdasarkan nama kategori (memerlukan join)
            $inboxes->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            });
        }

        // Terapkan sorting dan pagination, lalu simpan variabel search
        $inboxes = $inboxes->latest()->paginate(10)->withQueryString();
        // withQueryString() PENTING: memastikan parameter search tetap ada saat pindah halaman

        return view('inboxes.index', compact('inboxes', 'search'));
    }

    /**
     * Menampilkan formulir untuk membuat Surat Masuk baru.
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown form
        $categories = MailCategory::all();

        return view('inboxes.create', compact('categories'));
    }

    /**
     * Menyimpan data Surat Masuk yang baru dibuat.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'agenda_number' => 'required|string|max:255|unique:inboxes',
            'mail_number' => 'required|string|max:255|unique:inboxes',
            'mail_date' => 'required|date',
            'received_date' => 'required|date',
            'sender' => 'required|string|max:255',
            'intended_for' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'mail_category_id' => 'required|exists:mail_categories,id',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Maksimal 2MB
        ]);

        // 2. Handle File Upload (Jika ada)
        if ($request->hasFile('file_path')) {
            // $path = $request->file('file_path')->store('public/inboxes');
            // $validatedData['file_path'] = str_replace('public/', '', $path); // Simpan path tanpa 'public/'

            // Sebelum: $path = $request->file('file_path')->store('public/inboxes');
            // Ganti: 'inboxes' adalah folder di dalam disk 'public'
            $path = $request->file('file_path')->store('inboxes', 'public');
            $validatedData['file_path'] = $path; // path yang disimpan hanya 'inboxes/namafile.pdf'
        }

        // 3. Simpan ke Database
        Inbox::create($validatedData);

        return redirect()->route('inboxes.index')->with('success', 'Surat Masuk berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail Surat Masuk tertentu.
     */
    public function show(Inbox $inbox)
    {
        // Load relasi kategori
        $inbox->load('category');

        return view('inboxes.show', compact('inbox'));
    }

    /**
     * Menampilkan formulir untuk mengedit Surat Masuk.
     */
    public function edit(Inbox $inbox)
    {
        $categories = MailCategory::all();

        return view('inboxes.edit', compact('inbox', 'categories'));
    }

    /**
     * Memperbarui data Surat Masuk di database.
     */
    public function update(Request $request, Inbox $inbox)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            // unique harus mengabaikan id surat yang sedang diedit
            'agenda_number' => 'required|string|max:255|unique:inboxes,agenda_number,' . $inbox->id,
            'mail_number' => 'required|string|max:255|unique:inboxes,mail_number,' . $inbox->id,
            'mail_date' => 'required|date',
            'received_date' => 'required|date',
            'sender' => 'required|string|max:255',
            'intended_for' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'mail_category_id' => 'required|exists:mail_categories,id',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        // 2. Handle File Upload/Update (Jika ada)
        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($inbox->file_path && Storage::disk('public')->exists($inbox->file_path)) {
                Storage::disk('public')->delete($inbox->file_path);
            }
            // Simpan file baru
            // $path = $request->file('file_path')->store('public/inboxes');
            // $validatedData['file_path'] = str_replace('public/', '', $path);

            // Sebelum: $path = $request->file('file_path')->store('public/inboxes');
            // Ganti: 'inboxes' adalah folder di dalam disk 'public'
            $path = $request->file('file_path')->store('inboxes', 'public');
            $validatedData['file_path'] = $path; // path yang disimpan hanya 'inboxes/namafile.pdf'
        }

        // 3. Update ke Database
        $inbox->update($validatedData);

        return redirect()->route('inboxes.index')->with('success', 'Surat Masuk berhasil diperbarui!');
    }

    /**
     * Menghapus Surat Masuk dari database.
     */
    public function destroy(Inbox $inbox)
    {
        // 1. Hapus file terkait (jika ada)
        if ($inbox->file_path && Storage::disk('public')->exists($inbox->file_path)) {
            Storage::disk('public')->delete($inbox->file_path);
        }

        // 2. Hapus data dari database
        $inbox->delete();

        return redirect()->route('inboxes.index')->with('success', 'Surat Masuk berhasil dihapus!');
    }
}
