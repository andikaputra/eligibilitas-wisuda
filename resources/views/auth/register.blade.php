@extends('layouts.app')

@section('title', 'Registrasi Mahasiswa')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-7 col-lg-6">

            <div class="card shadow mt-5">

                <div class="card-header text-center py-3">

                    <h5 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-plus mr-2"></i>
                        Registrasi Mahasiswa
                    </h5>

                </div>

                <div class="card-body">

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <i class="fas fa-exclamation-circle mr-2"></i>

                        <strong>Registrasi gagal.</strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif
                    <p class="text-muted text-center mb-4">
                        Silakan daftarkan akun mahasiswa Anda.
                    </p>

<form action="{{ route('register') }}" method="POST">

    @csrf
                    {{-- NIM --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            NIM
                        </label>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Masukkan NIM"
                        >

                    </div>


                    {{-- Nama --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Masukkan nama lengkap"
                        >

                    </div>


                    {{-- Prodi --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            Program Studi
                        </label>

                        <select
                            name="prodi"
                            class="form-control"
                        >

                            <option value="">
                                -- Pilih Program Studi --
                            </option>

                            <option value="Pendidikan Bahasa dan Sastra Indonesia">
                                Pendidikan Bahasa dan Sastra Indonesia
                            </option>

                            <option value="Pendidikan Bahasa Inggris">
                                Pendidikan Bahasa Inggris
                            </option>

                            <option value="Pendidikan Guru Sekolah Dasar">
                                Pendidikan Guru Sekolah Dasar
                            </option>

                            <option value="Hukum Adat">
                                Hukum Adat
                            </option>

                            <option value="Pariwisata Budaya dan Keagamaan">
                                Pariwisata Budaya dan Keagamaan
                            </option>

                            <option value="Manajemen Ekonomi">
                                Manajemen Ekonomi
                            </option>

                            <option value="Akuntansi">
                                Akuntansi
                            </option>

                            <option value="Akuntansi PSDKU">
                                Akuntansi PSDKU
                            </option>

                            <option value="Sistem Informasi">
                                Sistem Informasi
                            </option>

                            <option value="Arsitektur">
                                Arsitektur
                            </option>

                            <option value="Desain Komunikasi Visual">
                                Desain Komunikasi Visual
                            </option>

                        </select>

                    </div>


                    {{-- Angkatan --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            Tahun Angkatan <span class="text-danger">*</span>
                        </label>

                        <select
                            name="angkatan"
                            class="form-control @error('angkatan') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Pilih Tahun Angkatan --</option>
                            @php
                                $curYear = (int) date('Y');
                            @endphp
                            @for ($year = $curYear + 1; $year >= $curYear - 10; $year--)
                                <option value="{{ $year }}" {{ old('angkatan', '2022') == $year ? 'selected' : '' }}>
                                    Angkatan {{ $year }}
                                </option>
                            @endfor
                        </select>

                        @error('angkatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="form-text text-muted">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Pilih tahun angkatan masuk kuliah Anda.
                        </small>

                    </div>


                    {{-- WhatsApp --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            No. WhatsApp
                        </label>

                        <input
                            type="text"
                            name="wa"
                            class="form-control"
                            placeholder="Masukkan nomor WhatsApp"
                        >

                    </div>


                    {{-- Password --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Buat password Anda"
                        >

                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Password minimal 6 karakter.
                        </small>

                    </div>


                    {{-- Konfirmasi Password --}}
                    <div class="form-group">

                        <label class="font-weight-bold">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password"
                        >

                    </div>


                    {{-- Tombol --}}
                    <button
                        type="submit"
                        class="btn btn-primary btn-block"
                    >

                        <i class="fas fa-user-plus mr-2"></i>

                        Daftar

                    </button>
            </form>

                    <div class="text-center mt-3">

                        <a href="{{ route('login') }}">
                            Sudah memiliki akun? Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection