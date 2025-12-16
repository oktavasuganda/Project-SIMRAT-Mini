@extends('layouts.app')

@section('content')
    {{-- Menggunakan komponen TailAdmin untuk breadcrumb --}}
    <x-common.page-breadcrumb pageTitle="Tambah Surat Masuk" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Input Data Surat Masuk Baru
                </h3>
            </div>

            @if ($errors->any())
                {{-- Anda mungkin punya komponen alert di TailAdmin, tapi ini basic HTML/Tailwind --}}
                <div class="mx-6 mt-4 bg-red-100 border border-red-400 text-red-700 dark:bg-red-800 dark:border-red-700 dark:text-red-200 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Ada masalah pada input data.</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('inboxes.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Baris 1: Nomor Agenda & Nomor Surat --}}
                    <div>
                        <x-forms.input type="text" label="Nomor Agenda" name="agenda_number" required />
                    </div>
                    <div>
                        <x-forms.input type="text" label="Nomor Surat" name="mail_number" required />
                    </div>

                    {{-- Baris 2: Tanggal Surat & Tanggal Diterima --}}
                    {{-- PENTING: Tambahkan ID unik untuk inisialisasi Datepicker --}}
                    <div>
                        <x-forms.date-picker type="date" label="Tanggal Surat" name="mail_date" id="mail_date"
                            required />
                    </div>
                    <div>
                        <x-forms.date-picker type="date" label="Tanggal Diterima" name="received_date" id="received_date"
                            required />
                    </div>

                    {{-- Baris 3: Pengirim & Ditujukan Kepada --}}
                    <div>
                        <x-forms.input type="text" label="Pengirim" name="sender" required />
                    </div>
                    <div>
                        <x-forms.input type="text" label="Ditujukan Kepada" name="intended_for" />
                    </div>

                    {{-- Baris 4: Kategori Surat (MENGGUNAKAN SELECT BARU) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label for="mail_category_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Surat <span
                                class="text-red-500">*</span></label>

                        {{-- Struktur Select yang Anda berikan, dibungkus Alpine.js --}}
                        <div x-data="{ isOptionSelected: !!'{{ old('mail_category_id') }}' }">
                            <select name="mail_category_id" id="mail_category_id" required
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                @change="isOptionSelected = true">

                                {{-- Opsi Default --}}
                                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" disabled
                                    selected>
                                    -- Pilih Kategori --
                                </option>

                                {{-- Looping Data Kategori --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                                        {{ old('mail_category_id') == $category->id ? 'selected' : '' }}>

                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('mail_category_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Baris 5: Subjek & Ringkasan --}}
                    <div class="col-span-1 md:col-span-2">
                        <x-forms.input type="text" label="Subjek" name="subject" required />
                    </div>



                    {{-- TEXTAREA BARU (Ringkasan) --}}
                    <div class="col-span-1 md:col-span-2">
                        <label for="summary" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Ringkasan
                        </label>
                        <textarea name="summary" id="summary" placeholder="Masukkan ringkasan surat..." rows="6"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('summary') }}</textarea>
                        @error('summary')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Baris 6: File Attachment --}}
                    <div class="col-span-1 md:col-span-2">
                        <label for="file_path"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload File</label>
                        <input type="file" name="file_path" id="file_path"
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 dark:file:bg-brand-900 file:text-brand-700 dark:file:text-brand-300 hover:file:bg-brand-100 dark:hover:file:bg-brand-800">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX, JPG, PNG (Max 2MB)</p>
                        @error('file_path')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('inboxes.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition duration-150">
                        Simpan Surat Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
