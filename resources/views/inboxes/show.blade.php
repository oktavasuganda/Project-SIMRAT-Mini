@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-white dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100">
        <h1 class="text-2xl font-bold mb-4">Detail Surat Masuk</h1>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b dark:border-gray-700 pb-4 mb-4">
                <h2 class="text-xl font-semibold md:col-span-2 text-gray-900 dark:text-gray-100">Informasi Utama</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="font-semibold text-gray-700 dark:text-gray-300">Nomor Agenda:</div>
                <div>{{ $inbox->agenda_number }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Nomor Surat:</div>
                <div>{{ $inbox->mail_number }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Tanggal Surat:</div>
                <div>{{ \Carbon\Carbon::parse($inbox->mail_date)->format('d F Y') }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Tanggal Diterima:</div>
                <div>{{ \Carbon\Carbon::parse($inbox->received_date)->format('d F Y') }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Pengirim:</div>
                <div>{{ $inbox->sender }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Ditujukan Kepada:</div>
                <div>{{ $inbox->intended_for ?? '-' }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Kategori:</div>
                <div>
                    <span
                        class="bg-indigo-200 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300 py-1 px-3 rounded-full text-sm">
                        {{ $inbox->category->name }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-b dark:border-gray-700 py-4 my-4">
                <h2 class="text-xl font-semibold md:col-span-2 text-gray-900 dark:text-gray-100">Subjek & Lampiran</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="font-semibold text-gray-700 dark:text-gray-300">Subjek:</div>
                <div class="md:col-span-2">{{ $inbox->subject }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Ringkasan:</div>
                <div class="md:col-span-2">{{ $inbox->summary ?? '-' }}</div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">File Attachment: </div>
                <div class="md:col-span-2">
                    @if ($inbox->file_path)
                        @php
                            $filePath = $inbox->file_path;
                            $fileUrl = $filePath ? Storage::url($filePath) : null;
                            $extension = $filePath ? pathinfo($filePath, PATHINFO_EXTENSION) : null;
                            $previewable = in_array(strtolower($extension), ['pdf', 'jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        {{-- 1. Tombol Download --}}
                        <a href="{{ $fileUrl }}" target="_blank"
                            class="text-blue-500 hover:underline dark:text-blue-400 dark:hover:text-blue-300 flex items-center mb-4">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                            </svg>
                            Download File ({{ strtoupper($extension) }})
                        </a>

                        {{-- 2. Kontainer Pratinjau --}}
                        @if ($previewable)
                            <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">Pratinjau Dokumen:</h4>
                            <div
                                class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden p-2 bg-gray-50 dark:bg-gray-700">

                                @if (strtolower($extension) === 'pdf')
                                    {{-- Viewer untuk PDF (Menggunakan Tag Iframe) --}}
                                    <iframe src="{{ $fileUrl }}" class="w-full" style="height: 600px;"
                                        frameborder="0">
                                        Browser Anda tidak mendukung pratinjau PDF.
                                    </iframe>
                                @elseif (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                    {{-- Viewer untuk Gambar (Menggunakan Tag Img) --}}
                                    <img src="{{ $fileUrl }}" alt="Pratinjau Dokumen"
                                        class="max-w-full h-auto rounded-md shadow-lg mx-auto" style="max-height: 600px;">
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">Pratinjau tidak tersedia untuk jenis file
                                        ini.</p>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Pratinjau tidak tersedia untuk jenis file ini
                                ({{ strtoupper($extension) }}).</p>
                        @endif
                    @else
                        <span class="text-gray-500 dark:text-gray-400">- Tidak Ada File -</span>
                    @endif
                </div>

                <div class="font-semibold text-gray-700 dark:text-gray-300">Dibuat Pada:</div>
                <div>{{ \Carbon\Carbon::parse($inbox->created_at)->format('d M Y H:i:s') }}</div>
            </div>

            <div class="mt-6 flex justify-end space-x-3 border-t dark:border-gray-700 pt-4">
                <a href="{{ route('inboxes.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                    Kembali ke Daftar
                </a>
                <a href="{{ route('inboxes.edit', $inbox) }}"
                    class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-150">
                    Edit Surat
                </a>
            </div>
        </div>
    </div>
@endsection
