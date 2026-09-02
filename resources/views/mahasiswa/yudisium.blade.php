@extends('layouts.app')

@section('title', 'Pendaftaran Yudisium')

@section('content')

@php
    $data = $data ?? null;
@endphp

<style>
    .yudisium-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 16px;
        padding: 28px 30px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.18);
    }

    .yudisium-header h3 {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .yudisium-header p {
        margin-bottom: 0;
        opacity: .9;
    }

    .document-card {
        background: #fff;
        border: 1px solid #e8ebf3;
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 18px;
        transition: all .2s ease;
    }

    .document-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,.06);
        transform: translateY(-1px);
    }

    .document-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: #4e73df;
        font-size: 20px;
        flex-shrink: 0;
    }

    .document-title {
        font-weight: 700;
        color: #344767;
        margin-bottom: 3px;
    }

    .document-subtitle {
        color: #858796;
        font-size: 13px;
        margin-bottom: 0;
    }

    .document-description {
        background: #f4f7ff;
        border-left: 4px solid #4e73df;
        border-radius: 8px;
        padding: 12px 15px;
        margin: 16px 0;
        color: #4a5568;
        font-size: 13px;
    }

    .document-input {
        border: 1px solid #dfe3eb;
        border-radius: 9px;
        padding: 11px 14px;
        height: 45px;
    }

    .document-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 .2rem rgba(78,115,223,.12);
    }

    .status-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    .status-success {
        background: #d1fae5;
        color: #047857;
    }

    .status-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .check-button {
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .save-section {
        background: #f8f9fc;
        border: 1px solid #e8ebf3;
        border-radius: 14px;
        padding: 20px;
        margin-top: 25px;
    }

    .save-button {
        padding: 11px 28px;
        border-radius: 9px;
        font-weight: 600;
    }

    .info-box {
        background: #eef4ff;
        border: 1px solid #dbe7ff;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 25px;
    }

    .info-box i {
        color: #4e73df;
        margin-right: 8px;
    }

    .info-box strong {
        color: #344767;
    }

    @media (max-width: 768px) {
        .yudisium-header {
            padding: 22px;
        }

        .document-card {
            padding: 17px;
        }

        .document-icon {
            width: 42px;
            height: 42px;
        }
    }
</style>


{{-- ===================================================== --}}
{{-- HEADER --}}
{{-- ===================================================== --}}

<div class="yudisium-header">

    <div class="d-flex align-items-center">

        <div class="mr-3">
            <i class="fas fa-graduation-cap fa-2x"></i>
        </div>

        <div>

            <h3>Pendaftaran Yudisium</h3>

            <p>
                Lengkapi seluruh persyaratan pendaftaran yudisium.
            </p>

        </div>

    </div>

</div>


{{-- ===================================================== --}}
{{-- INFORMASI --}}
{{-- ===================================================== --}}

<div class="info-box">

    <i class="fas fa-info-circle"></i>

    <strong>Petunjuk Pengumpulan Berkas:</strong>

    <div class="mt-2">
        Silakan masukkan link Google Drive untuk setiap bukti yang diminta.
        Pastikan link dapat diakses oleh pihak Universitas.
    </div>

    <div class="mt-2">
        Untuk Google Drive, gunakan pengaturan:
        <strong>Anyone with the link → Viewer</strong>.
    </div>

    <div class="mt-2">
        <strong>Catatan:</strong>
        Untuk foto, buat satu folder Google Drive yang berisi
        <strong>pas foto mahasiswa</strong> dan
        <strong>foto bersama orang tua/keluarga</strong>.
    </div>

</div>


{{-- ===================================================== --}}
{{-- SUCCESS --}}
{{-- ===================================================== --}}

@if(session('success'))

    <div class="alert alert-success border-0 shadow-sm">

        <i class="fas fa-check-circle mr-2"></i>

        {{ session('success') }}

    </div>

@endif

@if(session('error'))

    <div class="alert alert-danger border-0 shadow-sm">

        <i class="fas fa-exclamation-triangle mr-2"></i>

        {{ session('error') }}

    </div>

@endif


<form method="POST" action="{{ route('mahasiswa.yudisium.store') }}" enctype="multipart/form-data">

    @csrf


    {{-- ================================================= --}}
    {{-- 1. FOTO --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-camera"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Pas Foto & Foto Keluarga

                    @if($data && $data->validasi_foto == '1')

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_foto == '2')

                        <span class="status-badge status-danger ml-2">
                            <i class="fas fa-times-circle"></i>
                            Ditolak
                        </span>

                    @else

                        <span class="status-badge status-warning ml-2">
                            <i class="fas fa-clock"></i>
                            Belum divalidasi
                        </span>

                    @endif

                </div>

                <p class="document-subtitle">
                    Unggah file Pas Foto Mahasiswa dan Foto Bersama Orang Tua/Keluarga
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Pilih file foto dari perangkat Anda:
            <strong>1. Pas Foto Mahasiswa</strong> (formal) dan
            <strong>2. Foto Orang Tua / Keluarga</strong>.
            <br>
            <small class="text-muted">
                <i class="fas fa-cloud-upload-alt mr-1 text-primary"></i>
                Foto akan otomatis disimpan ke Google Drive Kampus dalam folder khusus akun Anda.
            </small>

        </div>

        {{-- STATUS FOTO YANG SUDAH ADA --}}
        @if($data && $data->link_foto)

            <div class="alert alert-light border d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="text-success font-weight-bold">
                        <i class="fas fa-check-circle mr-1"></i>
                        Foto Tersimpan di Google Drive
                    </span>
                    <br>
                    <small class="text-muted">Anda dapat mengunggah foto baru jika ingin memperbarui foto yang tersimpan.</small>
                </div>

                <a href="{{ $data->link_foto }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-external-link-alt mr-1"></i>
                    Buka Folder Drive Foto
                </a>
            </div>

        @endif

        <label class="font-weight-bold text-dark">
            Pilih File Foto (Bisa pilih 2 foto sekaligus: Pas Foto & Foto Keluarga)
        </label>

        <div class="custom-file mb-2">
            <input
                type="file"
                class="custom-file-input @error('foto_files') is-invalid @enderror"
                id="foto_files"
                name="foto_files[]"
                accept="image/png, image/jpeg, image/jpg"
                multiple
                onchange="previewPhotos(this)"
            >
            <label class="custom-file-label" for="foto_files" id="foto_files_label">
                Pilih foto (JPG / PNG, maks 5 MB per file)...
            </label>
        </div>

        @error('foto_files')
            <div class="text-danger small mt-1">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
            </div>
        @enderror

        @error('foto_files.*')
            <div class="text-danger small mt-1">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
            </div>
        @enderror

        {{-- AREA PREVIEW FOTO --}}
        <div id="photo-preview-container" class="row mt-3" style="display: none;"></div>

    </div>


    {{-- ================================================= --}}
    {{-- 2. PEMBAYARAN ALUMNI --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-credit-card"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Pembayaran Alumni & Kemahasiswaan

                    @if($data && $data->validasi_pembayaran_alumni == '1')

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_pembayaran_alumni == '2')

                        <span class="status-badge status-danger ml-2">
                            <i class="fas fa-times-circle"></i>
                            Ditolak
                        </span>

                    @else

                        <span class="status-badge status-warning ml-2">
                            <i class="fas fa-clock"></i>
                            Belum divalidasi
                        </span>

                    @endif

                </div>

                <p class="document-subtitle">
                    Bukti pembayaran alumni dan kemahasiswaan
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Masukkan link bukti pembayaran yang telah diberikan
            kepada pihak Universitas.

        </div>


        <label
            for="link_pembayaran_alumni"
            class="font-weight-bold text-dark"
        >
            Link Bukti Pembayaran Alumni
        </label>

        <input
            type="url"
            class="form-control document-input @error('link_pembayaran_alumni') is-invalid @enderror"
            id="link_pembayaran_alumni"
            name="link_pembayaran_alumni"
            value="{{ old('link_pembayaran_alumni', $data->link_pembayaran_alumni ?? '') }}"
            placeholder="https://drive.google.com/..."
            required
        >

        @error('link_pembayaran_alumni')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror


        <div class="mt-3">

            <button
                type="button"
                onclick="cekLink('link_pembayaran_alumni', 'bukti pembayaran alumni')"
                class="btn btn-info check-button"
            >

                <i class="fas fa-external-link-alt mr-1"></i>

                Cek Bukti Pembayaran Alumni

            </button>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- 3. BEBAS KEUANGAN --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-wallet"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Bebas Administrasi Keuangan

                    @if($data && $data->validasi_bebas_keuangan == '1')

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_bebas_keuangan == '2')

                        <span class="status-badge status-danger ml-2">
                            <i class="fas fa-times-circle"></i>
                            Ditolak
                        </span>

                    @else

                        <span class="status-badge status-warning ml-2">
                            <i class="fas fa-clock"></i>
                            Belum divalidasi
                        </span>

                    @endif

                </div>

                <p class="document-subtitle">
                    Bukti bebas administrasi keuangan
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Masukkan link bukti bebas administrasi keuangan
            dari pihak yang berwenang.

        </div>


        <label
            for="link_bebas_keuangan"
            class="font-weight-bold text-dark"
        >
            Link Bukti Bebas Keuangan
        </label>

        <input
            type="url"
            class="form-control document-input @error('link_bebas_keuangan') is-invalid @enderror"
            id="link_bebas_keuangan"
            name="link_bebas_keuangan"
            value="{{ old('link_bebas_keuangan', $data->link_bebas_keuangan ?? '') }}"
            placeholder="https://drive.google.com/..."
            required
        >

        @error('link_bebas_keuangan')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror


        <div class="mt-3">

            <button
                type="button"
                onclick="cekLink('link_bebas_keuangan', 'bukti bebas keuangan')"
                class="btn btn-info check-button"
            >

                <i class="fas fa-external-link-alt mr-1"></i>

                Cek Bukti Bebas Keuangan

            </button>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- 4. PEMBAYARAN YUDISIUM --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-graduation-cap"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Pembayaran Yudisium

                    @if($data && $data->validasi_pembayaran_yudisium == '1')

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_pembayaran_yudisium == '2')

                        <span class="status-badge status-danger ml-2">
                            <i class="fas fa-times-circle"></i>
                            Ditolak
                        </span>

                    @else

                        <span class="status-badge status-warning ml-2">
                            <i class="fas fa-clock"></i>
                            Belum divalidasi
                        </span>

                    @endif

                </div>

                <p class="document-subtitle">
                    Bukti pembayaran pendaftaran yudisium
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Masukkan link bukti pembayaran yudisium yang
            dapat diakses oleh pihak Universitas.

        </div>


        <label
            for="link_pembayaran_yudisium"
            class="font-weight-bold text-dark"
        >
            Link Bukti Pembayaran Yudisium
        </label>

        <input
            type="url"
            class="form-control document-input @error('link_pembayaran_yudisium') is-invalid @enderror"
            id="link_pembayaran_yudisium"
            name="link_pembayaran_yudisium"
            value="{{ old('link_pembayaran_yudisium', $data->link_pembayaran_yudisium ?? '') }}"
            placeholder="https://drive.google.com/..."
            required
        >

        @error('link_pembayaran_yudisium')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror


        <div class="mt-3">

            <button
                type="button"
                onclick="cekLink('link_pembayaran_yudisium', 'bukti pembayaran yudisium')"
                class="btn btn-info check-button"
            >

                <i class="fas fa-external-link-alt mr-1"></i>

                Cek Bukti Pembayaran Yudisium

            </button>

        </div>

    </div>

{{-- ================================================= --}}
{{-- 5. ARTIKEL PUBLISH / LOA --}}
{{-- ================================================= --}}

<div class="document-card">

    <div class="document-header">

        <div class="d-flex align-items-center">

            <div class="document-icon">

                <i class="fas fa-newspaper"></i>

            </div>

            <div class="ml-3">

                <div class="d-flex align-items-center">

                    <h5 class="font-weight-bold text-dark mb-0">
                        Artikel Publish / LOA
                    </h5>

                    @if($data && $data->validasi_artikel_loa == '1')

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_artikel_loa == '2')

                        <span class="status-badge status-danger ml-2">
                            <i class="fas fa-times-circle"></i>
                            Ditolak / Perlu diperbaiki
                        </span>

                    @else

                        <span class="status-badge status-warning ml-2">
                            <i class="fas fa-clock"></i>
                            Belum divalidasi
                        </span>

                    @endif

                </div>

                <p class="document-subtitle">
                    Bukti artikel yang telah dipublish atau Letter of Acceptance (LOA)
                </p>

            </div>

        </div>

    </div>


    <div class="document-description">

        <i class="fas fa-info-circle mr-1"></i>

        Masukkan link bukti artikel yang telah dipublish atau
        Letter of Acceptance (LOA) yang dapat diakses oleh pihak Universitas.

    </div>


    <label
        for="link_artikel_loa"
        class="font-weight-bold text-dark"
    >
        Link Bukti Artikel Publish / LOA
    </label>


    <input
        type="url"
        class="form-control document-input @error('link_artikel_loa') is-invalid @enderror"
        id="link_artikel_loa"
        name="link_artikel_loa"
        value="{{ old('link_artikel_loa', $data->link_artikel_loa ?? '') }}"
        placeholder="https://drive.google.com/..."
        required
    >


    @error('link_artikel_loa')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror


    <div class="mt-3">

        <button
            type="button"
            onclick="cekLink('link_artikel_loa', 'bukti artikel publish / LOA')"
            class="btn btn-info check-button"
        >

            <i class="fas fa-external-link-alt mr-1"></i>

            Cek Bukti Artikel / LOA

        </button>

    </div>

</div>

    {{-- ================================================= --}}
    {{-- SIMPAN --}}
    {{-- ================================================= --}}

    <div class="save-section d-flex align-items-center justify-content-between">

        <div>

            <div class="font-weight-bold text-dark">

                <i class="fas fa-save mr-1"></i>

                Simpan Data Yudisium

            </div>

            <small class="text-muted">

                Pastikan seluruh link sudah benar sebelum menyimpan.

            </small>

        </div>


        <button
            type="submit"
            class="btn btn-primary save-button"
        >

            <i class="fas fa-save mr-1"></i>

            Simpan Data

        </button>

    </div>

</form>

{{-- ===================================================== --}}
{{-- KARTU PESERTA YUDISIUM & WISUDA --}}
{{-- ===================================================== --}}

@php
    $yudisiumLengkap =
        $data &&
        $data->validasi_foto == 1 &&
        $data->validasi_pembayaran_alumni == 1 &&
        $data->validasi_bebas_keuangan == 1 &&
        $data->validasi_pembayaran_yudisium == 1;
        $data->validasi_artikel_loa == 1;
@endphp

<div class="card shadow mt-4 mb-4">

    <div class="card-body text-center">

        <div class="mb-3">

            <i class="fas fa-id-card fa-3x text-primary"></i>

        </div>

        <h5 class="font-weight-bold text-dark">
            Kartu Peserta Yudisium & Wisuda
        </h5>

        @if($yudisiumLengkap)

            <p class="text-success mb-3">
                <i class="fas fa-check-circle mr-1"></i>
                Seluruh persyaratan Yudisium telah divalidasi.
            </p>

            <a
                href="{{ route('mahasiswa.yudisium.kartuYudisium') }}"
                class="btn btn-primary"
            >
                <i class="fas fa-id-card mr-1"></i>
                Lihat Kartu Peserta
            </a>

        @else

            <p class="text-muted mb-3">
                <i class="fas fa-clock mr-1"></i>
                Kartu akan tersedia setelah seluruh persyaratan
                Yudisium selesai divalidasi.
            </p>

            <button
                type="button"
                class="btn btn-secondary"
                disabled
            >
                <i class="fas fa-lock mr-1"></i>
                Kartu Belum Tersedia
            </button>

        @endif

    </div>

</div>

{{-- ===================================================== --}}
{{-- JAVASCRIPT CEK LINK --}}
{{-- ===================================================== --}}

<script>

function cekLink(inputId, namaDokumen)
{
    const input = document.getElementById(inputId);

    const url = input.value.trim();

    if (!url) {

        alert('Silakan masukkan link ' + namaDokumen + ' terlebih dahulu.');

        input.focus();

        return;
    }

    try {

        const parsedUrl = new URL(url);

        if (parsedUrl.protocol !== 'http:' && parsedUrl.protocol !== 'https:') {

            alert('Link tidak valid. Gunakan link yang diawali dengan https://');

            input.focus();

            return;
        }

        window.open(
            parsedUrl.href,
            '_blank',
            'noopener,noreferrer'
        );

    } catch (error) {
        alert('Link tidak valid. Silakan periksa kembali link yang dimasukkan.');
        input.focus();
    }
}

function previewPhotos(input) {
    const container = document.getElementById('photo-preview-container');
    const label = document.getElementById('foto_files_label');
    container.innerHTML = '';

    if (!input.files || input.files.length === 0) {
        container.style.display = 'none';
        label.innerText = 'Pilih foto (JPG / PNG, maks 5 MB per file)...';
        return;
    }

    label.innerText = input.files.length + ' file foto dipilih';
    container.style.display = 'flex';

    Array.from(input.files).forEach((file, index) => {
        if (!file.type.match('image.*')) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 mb-3';
            
            let labelText = 'Foto ' + (index + 1);
            if (input.files.length === 2) {
                labelText = index === 0 ? '1. Pas Foto' : '2. Foto Keluarga';
            }

            col.innerHTML = `
                <div class="card h-100 shadow-sm border">
                    <div style="height: 140px; overflow: hidden; background: #f8f9fa;" class="d-flex align-items-center justify-content-center">
                        <img src="${e.target.result}" alt="Preview" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body p-2 text-center">
                        <span class="badge badge-primary mb-1">${labelText}</span>
                        <p class="small text-truncate mb-0 text-muted" title="${file.name}">${file.name}</p>
                        <small class="text-muted">(${(file.size / (1024 * 1024)).toFixed(2)} MB)</small>
                    </div>
                </div>
            `;
            container.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
}

</script>

@endsection