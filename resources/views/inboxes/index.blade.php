@extends('layouts.app')
{{-- Ganti 'layouts.app' dengan layout TailAdmin Anda --}}

@section('content')
    {{-- Kontainer utama yang akan berubah warna latar belakang --}}
    <div class="container mx-auto p-4 bg-white dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100">
        <h1 class="text-2xl font-bold mb-4">Daftar Surat Masuk</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:border-green-700 dark:text-green-200 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('inboxes.create') }}"
                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white font-bold py-2 px-4 rounded transition duration-150">
                Tambah Surat Masuk
            </a>
        </div>

        {{-- Tabel dan Kontainer Tabel --}}
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr
                        class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Agenda/Nomor Surat</th>
                        <th class="py-3 px-6 text-left">Pengirim</th>
                        <th class="py-3 px-6 text-left">Subjek</th>
                        <th class="py-3 px-6 text-center">Kategori</th>
                        <th class="py-3 px-6 text-center">Tgl Diterima</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-300 text-sm font-light">
                    @forelse ($inboxes as $inbox)
                        <tr
                            class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <span class="font-medium block">No. Agenda: {{ $inbox->agenda_number }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 block">No. Surat:
                                    {{ $inbox->mail_number }}</span>
                            </td>
                            <td class="py-3 px-6 text-left">{{ $inbox->sender }}</td>
                            <td class="py-3 px-6 text-left">{{ Str::limit($inbox->subject, 50) }}</td>
                            <td class="py-3 px-6 text-center">
                                {{-- Badge Category --}}
                                <span
                                    class="bg-indigo-200 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300 py-1 px-3 rounded-full text-xs">
                                    {{ $inbox->category->name }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                {{ \Carbon\Carbon::parse($inbox->received_date)->format('d-m-Y') }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('inboxes.show', $inbox) }}"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">Lihat</a>
                                    <a href="{{ route('inboxes.edit', $inbox) }}"
                                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">Edit</a>
                                    <form action="{{ route('inboxes.destroy', $inbox) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data surat masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{-- Paginasi (perlu penyesuaian untuk dark mode di vendor view) --}}
            {{ $inboxes->links() }}
        </div>
    </div>
@endsection
