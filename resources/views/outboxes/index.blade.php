@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-white dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100">
        <x-common.page-breadcrumb pageTitle="Daftar Surat Keluar" />

        {{-- Blok Pesan Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:border-green-700 dark:text-green-200 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Filter/Search dan Tombol Tambah --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-3 md:space-y-0">

            {{-- BAGIAN KIRI: Tombol Tambah --}}
            <div class="w-full md:w-auto order-2 md:order-1">
                <a href="{{ route('outboxes.create') }}"
                    class="bg-brand-600 hover:bg-brand-700 dark:bg-brand-700 dark:hover:bg-brand-800 text-white font-bold py-2 px-4 rounded transition duration-150 w-full inline-block text-center md:w-auto">
                    Tambah Surat Keluar
                </a>
            </div>

            {{-- BAGIAN KANAN: FORM PENCARIAN --}}
            <form action="{{ route('outboxes.index') }}" method="GET" class="order-1 md:order-2 w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari Nomor Surat, Tujuan, atau Subjek..."
                        value="{{ $search ?? '' }}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-800 dark:text-white/90 dark:placeholder:text-white/30" />

                    <button type="submit"
                        class="absolute right-0 top-0 h-full w-10 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>

                @if ($search)
                    <div class="mt-2 text-right">
                        <a href="{{ route('outboxes.index') }}"
                            class="text-xs text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                            Hapus Pencarian (Saat Ini: "{{ $search }}")
                        </a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Tabel Data Surat Keluar --}}
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr
                        class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Agenda/Nomor Surat</th>
                        <th class="py-3 px-6 text-left">Tujuan & Subjek</th>
                        <th class="py-3 px-6 text-center">Kategori</th>
                        <th class="py-3 px-6 text-center">Tgl Surat</th> {{-- Di sini berbeda dengan inbox --}}
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-300 text-sm font-light">
                    @forelse ($outboxes as $outbox)
                        <tr
                            class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <span class="font-medium block">Agenda: {{ $outbox->agenda_number }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 block">Surat:
                                    {{ $outbox->mail_number }}</span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <span class="font-medium block">{{ Str::limit($outbox->subject, 60) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 block">Tujuan:
                                    {{ $outbox->intended_for }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span
                                    class="bg-indigo-200 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300 py-1 px-3 rounded-full text-xs">
                                    {{ $outbox->category->name }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                {{ \Carbon\Carbon::parse($outbox->mail_date)->format('d-m-Y') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('outboxes.show', $outbox) }}"
                                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
                                        title="Lihat Detail">
                                        Lihat
                                    </a>
                                    <a href="{{ route('outboxes.edit', $outbox) }}"
                                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200"
                                        title="Edit Data">
                                        Edit
                                    </a>
                                    <form action="{{ route('outboxes.destroy', $outbox) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat {{ $outbox->mail_number }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
                                            title="Hapus Data">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 px-6 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data surat keluar yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $outboxes->links() }}
        </div>
    </div>
@endsection
