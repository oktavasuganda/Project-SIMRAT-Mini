<?php

namespace App\Http\Controllers;

use App\Models\Outbox;
use App\Models\MailCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutboxController extends Controller
{
    /**
     * Menampilkan daftar data Surat Keluar dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $outboxes = Outbox::with('category');

        if ($search) {
            $outboxes->where(function ($query) use ($search) {
                $query->where('agenda_number', 'LIKE', "%{$search}%")
                    ->orWhere('mail_number', 'LIKE', "%{$search}%")
                    ->orWhere('intended_for', 'LIKE', "%{$search}%")
                    ->orWhere('subject', 'LIKE', "%{$search}%");
            });

            $outboxes->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            });
        }

        $outboxes = $outboxes->latest()->paginate(10)->withQueryString();

        return view('outboxes.index', compact('outboxes', 'search'));
    }

    /**
     * Menampilkan formulir untuk membuat Surat Keluar baru.
     */
    public function create()
    {
        $categories = MailCategory::all();

        return view('outboxes.create', compact('categories'));
    }

    /**
     * Menyimpan data Surat Keluar yang baru dibuat.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'agenda_number' => 'required|string|max:255|unique:outboxes',
            'mail_number' => 'required|string|max:255|unique:outboxes',
            'mail_date' => 'required|date',
            'intended_for' => 'required|string|max:255', // Di outbox ini wajib
            'subject' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'mail_category_id' => 'required|exists:mail_categories,id',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            // Simpan ke disk public, folder 'outboxes'
            $path = $request->file('file_path')->store('outboxes', 'public');
            $validatedData['file_path'] = $path;
        }

        Outbox::create($validatedData);

        return redirect()->route('outboxes.index')->with('success', 'Surat Keluar berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail Surat Keluar tertentu.
     */
    public function show(Outbox $outbox)
    {
        $outbox->load('category');

        return view('outboxes.show', compact('outbox'));
    }

    /**
     * Menampilkan formulir untuk mengedit Surat Keluar.
     */
    public function edit(Outbox $outbox)
    {
        $categories = MailCategory::all();

        return view('outboxes.edit', compact('outbox', 'categories'));
    }

    /**
     * Memperbarui data Surat Keluar di database.
     */
    public function update(Request $request, Outbox $outbox)
    {
        $validatedData = $request->validate([
            'agenda_number' => 'required|string|max:255|unique:outboxes,agenda_number,' . $outbox->id,
            'mail_number' => 'required|string|max:255|unique:outboxes,mail_number,' . $outbox->id,
            'mail_date' => 'required|date',
            'intended_for' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'mail_category_id' => 'required|exists:mail_categories,id',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($outbox->file_path && Storage::disk('public')->exists($outbox->file_path)) {
                Storage::disk('public')->delete($outbox->file_path);
            }
            // Simpan file baru
            $path = $request->file('file_path')->store('outboxes', 'public');
            $validatedData['file_path'] = $path;
        }

        $outbox->update($validatedData);

        return redirect()->route('outboxes.index')->with('success', 'Surat Keluar berhasil diperbarui!');
    }

    /**
     * Menghapus Surat Keluar dari database.
     */
    public function destroy(Outbox $outbox)
    {
        // Hapus file terkait (jika ada)
        if ($outbox->file_path && Storage::disk('public')->exists($outbox->file_path)) {
            Storage::disk('public')->delete($outbox->file_path);
        }

        $outbox->delete();

        return redirect()->route('outboxes.index')->with('success', 'Surat Keluar berhasil dihapus!');
    }
}
