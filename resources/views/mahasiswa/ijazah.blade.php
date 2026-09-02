@extends('layouts.app')

@section('title', 'Data Ijazah')

@section('content')
    @php
        $statusLabels = [
            1 => ['class' => 'success', 'icon' => 'check-circle', 'label' => 'Valid'],
            2 => ['class' => 'danger', 'icon' => 'times-circle', 'label' => 'Perlu diperbaiki'],
        ];

        $fields = [
            ['name' => 'nama', 'label' => 'Nama Lengkap', 'type' => 'text', 'placeholder' => 'Nama lengkap sesuai dokumen resmi'],
            ['name' => 'nik', 'label' => 'NIK', 'type' => 'text', 'placeholder' => '16 digit NIK'],
            ['name' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'type' => 'text', 'placeholder' => 'Contoh: Denpasar'],
            ['name' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'type' => 'date', 'placeholder' => ''],
            ['name' => 'nim', 'label' => 'NIM', 'type' => 'text', 'placeholder' => 'Masukkan NIM'],
        ];

        $prodiList = [
            'Pendidikan Bahasa dan Sastra Indonesia',
            'Pendidikan Bahasa Inggris',
            'Pendidikan Guru Sekolah Dasar',
            'Hukum Adat',
            'Pariwisata Budaya dan Keagamaan',
            'Manajemen Ekonomi',
            'Akuntansi',
            'Akuntansi PSDKU',
            'Sistem Informasi',
            'Arsitektur',
            'Desain Komunikasi Visual',
        ];
    @endphp

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Data Ijazah</h1>
                <p class="mb-0 text-muted">Periksa dan lengkapi data yang akan digunakan untuk pembuatan ijazah.</p>
            </div>
        </div>

        <div class="alert alert-info shadow-sm" role="alert">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Perhatian:</strong> Pastikan data sesuai dokumen resmi. Data yang disimpan akan diperiksa oleh universitas.
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm" role="alert">
                <strong><i class="fas fa-exclamation-circle mr-2"></i>Data belum dapat disimpan.</strong>
                <span class="d-block mt-1">Periksa kembali kolom yang diberi tanda merah.</span>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-id-card mr-2"></i>Form Data Ijazah
                </h6>
            </div>

            <div class="card-body">
                @if ($ijazah)
                    <div class="alert alert-light border mb-4" role="status">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        Status tiap kolom: <strong>Menunggu</strong>, <strong>Valid</strong>, atau <strong>Perlu diperbaiki</strong>.
                    </div>
                @endif

                <form action="{{ route('mahasiswa.ijazah.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row">
                        @foreach ($fields as $field)
                            @php
                                $statusColumn = 'validasi_' . $field['name'];
                                $status = $ijazah ? $ijazah->{$statusColumn} : null;
                                $value = old($field['name'], $ijazah ? $ijazah->{$field['name']} : '');

                                if ($field['name'] === 'tanggal_lahir' && $value instanceof \DateTimeInterface) {
                                    $value = $value->format('Y-m-d');
                                }
                            @endphp

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $field['name'] }}" class="font-weight-bold">
                                        {{ $field['label'] }} <span class="text-danger">*</span>

                                        @if ($ijazah)
                                            @if ($status === null)
                                                <span class="badge badge-warning ml-1">
                                                    <i class="fas fa-clock mr-1"></i>Menunggu
                                                </span>
                                            @elseif (isset($statusLabels[$status]))
                                                <span class="badge badge-{{ $statusLabels[$status]['class'] }} ml-1">
                                                    <i class="fas fa-{{ $statusLabels[$status]['icon'] }} mr-1"></i>{{ $statusLabels[$status]['label'] }}
                                                </span>
                                            @endif
                                        @endif
                                    </label>

                                    <input
                                        type="{{ $field['type'] }}"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}"
                                        class="form-control @error($field['name']) is-invalid @enderror"
                                        value="{{ $value }}"
                                        placeholder="{{ $field['placeholder'] }}"
                                        @if ($field['name'] === 'nik') maxlength="16" inputmode="numeric" @endif
                                        required
                                    >

                                    @error($field['name'])
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        @php
                            $status = $ijazah ? $ijazah->validasi_prodi : null;
                            $prodiTerpilih = old('prodi', $ijazah->prodi ?? '');
                        @endphp

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prodi" class="font-weight-bold">
                                    Program Studi <span class="text-danger">*</span>

                                    @if ($ijazah)
                                        @if ($status === null)
                                            <span class="badge badge-warning ml-1">
                                                <i class="fas fa-clock mr-1"></i>Menunggu
                                            </span>
                                        @elseif (isset($statusLabels[$status]))
                                            <span class="badge badge-{{ $statusLabels[$status]['class'] }} ml-1">
                                                <i class="fas fa-{{ $statusLabels[$status]['icon'] }} mr-1"></i>{{ $statusLabels[$status]['label'] }}
                                            </span>
                                        @endif
                                    @endif
                                </label>

                                <select id="prodi" name="prodi" class="form-control @error('prodi') is-invalid @enderror" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach ($prodiList as $prodi)
                                        <option value="{{ $prodi }}" @selected($prodiTerpilih === $prodi)>
                                            {{ $prodi }}@if ($prodi === 'Akuntansi PSDKU') (Mataram)@endif
                                        </option>
                                    @endforeach
                                </select>

                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Simpan Data Ijazah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
