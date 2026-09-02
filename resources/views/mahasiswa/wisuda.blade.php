@extends('layouts.app')

@section('title', 'Pendaftaran Wisuda')

@section('content')

@php
    $data = $data ?? null;
@endphp

<style>
    .wisuda-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 16px;
        padding: 28px 30px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.18);
    }

    .wisuda-header h3 {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .wisuda-header p {
        margin-bottom: 0;
        opacity: .9;
    }

    .info-box {
        background: #eef4ff;
        border: 1px solid #dbe7ff;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 25px;
        color: #4a5568;
    }

    .info-box i {
        color: #4e73df;
        margin-right: 8px;
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

    @media (max-width: 768px) {
        .wisuda-header {
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

<div class="wisuda-header">
    <div class="d-flex align-items-center">

        <div class="mr-3">
            <i class="fas fa-graduation-cap fa-2x"></i>
        </div>

        <div>
            <h3>Pendaftaran Wisuda</h3>

            <p>
                Lengkapi seluruh persyaratan wisuda dengan memasukkan
                link dokumen yang diperlukan.
            </p>
        </div>

    </div>
</div>


{{-- ===================================================== --}}
{{-- INFORMASI --}}
{{-- ===================================================== --}}

<div class="info-box">

    <i class="fas fa-info-circle"></i>

    <strong>Petunjuk:</strong>

    Pastikan seluruh link yang dimasukkan dapat diakses oleh
    pihak Universitas.

    Untuk file Google Drive, gunakan pengaturan:

    <strong>Anyone with the link → Viewer</strong>.

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


<form
    method="POST"
    action="{{ route('mahasiswa.wisuda.store') }}"
>

    @csrf


    {{-- ================================================= --}}
    {{-- REPOSITORY --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-book-open"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Repository

                    @if($data && $data->validasi_repositori == 1)

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_repositori == 2)

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
                    Link repository skripsi mahasiswa
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Masukkan link repository skripsi yang sudah
            dipublikasikan.

        </div>


        <label
            for="link_repositori"
            class="font-weight-bold text-dark"
        >
            Link Repository
        </label>


        <input
            type="url"
            class="form-control document-input @error('link_repositori') is-invalid @enderror"
            id="link_repositori"
            name="link_repositori"
            value="{{ old('link_repositori', $data->link_repositori ?? '') }}"
            required
        >


        @error('link_repositori')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror


        <div class="mt-3">

            <button
                type="button"
                class="btn btn-info check-button"
                onclick="cekLink('link_repositori', 'link Repository')"
            >

                <i class="fas fa-external-link-alt mr-1"></i>

                Cek Link Repository

            </button>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- TRACER STUDY --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-user-graduate"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Tracer Study

                    @if($data && $data->validasi_tracer_study == 1)

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_tracer_study == 2)

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
                    Bukti telah mengisi Tracer Study
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Masukkan link bukti pengisian Tracer Study.

        </div>


        <label
            for="link_tracer_study"
            class="font-weight-bold text-dark"
        >
            Link Tracer Study
        </label>


        <input
            type="url"
            class="form-control document-input @error('link_tracer_study') is-invalid @enderror"
            id="link_tracer_study"
            name="link_tracer_study"
            value="{{ old('link_tracer_study', $data->link_tracer_study ?? '') }}"
            required
        >


        @error('link_tracer_study')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror


        <div class="mt-3">

            <button
                type="button"
                class="btn btn-info check-button"
                onclick="cekLink('link_tracer_study', 'link Tracer Study')"
            >

                <i class="fas fa-external-link-alt mr-1"></i>

                Cek Link Tracer Study

            </button>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- PEMBAYARAN WISUDA --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-money-bill-wave"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Pembayaran Wisuda

                    @if($data && $data->validasi_pembayaran_wisuda == 1)

                        <span class="status-badge status-success ml-2">
                            <i class="fas fa-check-circle"></i>
                            Sudah divalidasi
                        </span>

                    @elseif($data && $data->validasi_pembayaran_wisuda == 2)

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
                    Bukti pembayaran biaya wisuda
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Masukkan link bukti pembayaran wisuda.
            Pastikan file dapat dibuka oleh pihak Universitas.

        </div>


        <label
            for="link_pembayaran_wisuda"
            class="font-weight-bold text-dark"
        >
            Link Bukti Pembayaran Wisuda
        </label>


        <input
            type="url"
            class="form-control document-input @error('link_pembayaran_wisuda') is-invalid @enderror"
            id="link_pembayaran_wisuda"
            name="link_pembayaran_wisuda"
            value="{{ old('link_pembayaran_wisuda', $data->link_pembayaran_wisuda ?? '') }}"
            required
        >


        @error('link_pembayaran_wisuda')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror


        <div class="mt-3">

            <button
                type="button"
                class="btn btn-info check-button"
                onclick="cekLink('link_pembayaran_wisuda', 'link pembayaran Wisuda')"
            >

                <i class="fas fa-external-link-alt mr-1"></i>

                Cek Link Pembayaran Wisuda

            </button>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- BEBAS PERPUSTAKAAN --}}
    {{-- ================================================= --}}

    <div class="document-card">

        <div class="d-flex align-items-center">

            <div class="document-icon mr-3">
                <i class="fas fa-book"></i>
            </div>

            <div class="flex-grow-1">

                <div class="document-title">

                    Bebas Perpustakaan

                    {{-- VALIDASI KHUSUS WISUDA --}}

                    @if($data && $data->validasi_bebas_perpus_wisuda == 1)

                        <span class="status-badge status-success ml-2">

                            <i class="fas fa-check-circle"></i>

                            Sudah divalidasi

                        </span>

                    @elseif($data && $data->validasi_bebas_perpus_wisuda == 2)

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
                    Bukti bebas administrasi perpustakaan
                </p>

            </div>

        </div>


        <div class="document-description">

            <i class="fas fa-info-circle mr-1"></i>

            Masukkan link bukti bebas perpustakaan.

        </div>


        <label
            for="link_bukti_perpus"
            class="font-weight-bold text-dark"
        >
            Link Bukti Bebas Perpustakaan
        </label>


        <input
            type="url"
            class="form-control document-input @error('link_bukti_perpus') is-invalid @enderror"
            id="link_bukti_perpus"
            name="link_bukti_perpus"
            value="{{ old('link_bukti_perpus', $data->link_bukti_perpus ?? '') }}"
            required
        >


        @error('link_bukti_perpus')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror


        <div class="mt-3">

            <button
                type="button"
                class="btn btn-info check-button"
                onclick="cekLink('link_bukti_perpus', 'link bukti Bebas Perpustakaan')"
            >

                <i class="fas fa-external-link-alt mr-1"></i>

                Cek Link Bebas Perpustakaan

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

                Simpan Data Wisuda

            </div>

            <small class="text-muted">

                Pastikan semua link sudah benar sebelum menyimpan.

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
{{-- JAVASCRIPT CEK LINK --}}
{{-- ===================================================== --}}

<script>

    function cekLink(inputId, namaDokumen)
    {
        const input = document.getElementById(inputId);

        if (!input) {
            alert('Input ' + namaDokumen + ' tidak ditemukan.');
            return;
        }

        const link = input.value.trim();

        if (!link) {

            alert(
                'Silakan masukkan ' +
                namaDokumen +
                ' terlebih dahulu.'
            );

            input.focus();

            return;
        }

        window.open(
            link,
            '_blank',
            'noopener,noreferrer'
        );
    }

</script>

{{-- ========================================================= --}}
{{-- STATUS PENDAFTARAN WISUDA --}}
{{-- ========================================================= --}}

@php
    $wisudaSudahValid =
        $data &&
        $data->validasi_bendahara == 1 &&
        $data->validasi_repositori == 1 &&
        $data->validasi_tracer_study == 1 &&
        $data->validasi_bebas_perpus_wisuda == 1;
@endphp

@if($wisudaSudahValid && $data->no_urut)

    {{-- SUDAH TERDAFTAR WISUDA --}}
    <div class="card shadow-sm mt-4">
        <div class="card-body text-center py-4">

            <div class="mb-3">
                <i class="fas fa-graduation-cap"
                   style="font-size: 45px; color: #4e73df;"></i>
            </div>

            <h4 class="font-weight-bold text-dark">
                Anda Sudah Terdaftar sebagai Peserta Wisuda
            </h4>

            <p class="text-muted mb-2">
                Seluruh persyaratan Wisuda Anda telah divalidasi.
            </p>

            <div class="mt-3">
                <span class="text-muted">
                    Nomor Urut Wisuda
                </span>

                <h2 class="font-weight-bold text-primary mb-0">
                    {{ $data->no_urut }}
                </h2>
            </div>

        </div>
    </div>

@else

    {{-- MASIH MENUNGGU VALIDASI --}}
    <div class="card shadow-sm mt-4">
        <div class="card-body text-center py-4">

            <div class="mb-3">
                <i class="fas fa-hourglass-half"
                   style="font-size: 42px; color: #f6c23e;"></i>
            </div>

            <h4 class="font-weight-bold text-dark">
                Menunggu Validasi Persyaratan Wisuda
            </h4>

            <p class="text-muted mb-0">
                Silakan menunggu seluruh persyaratan Wisuda
                selesai divalidasi oleh pihak Universitas.
            </p>

        </div>
    </div>

@endif

@endsection