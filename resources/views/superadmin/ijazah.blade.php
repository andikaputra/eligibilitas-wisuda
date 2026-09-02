@extends('layouts.app')

@section('title', 'Validasi Ijazah')

@section('content')
    @php
        $statusFields = [
            'nama' => 'Nama',
            'nik' => 'NIK',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tgl Lahir',
            'nim' => 'NIM',
            'prodi' => 'Prodi',
        ];

        $statusDots = [
            1 => ['color' => '#1cc88a', 'label' => 'Valid'],
            2 => ['color' => '#e74a3b', 'label' => 'Perlu diperbaiki'],
        ];
    @endphp

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Validasi Ijazah</h1>
                <p class="mb-0 text-muted">Validasi seluruh data Ijazah yang dikirim oleh mahasiswa.</p>
            </div>

            <a href="{{ route('superadmin.ijazah.export-pdf') }}" class="btn btn-danger shadow-sm mt-3 mt-sm-0">
                <i class="fas fa-file-pdf mr-1"></i>Export PDF
            </a>
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
                <i class="fas fa-exclamation-circle mr-2"></i>
                Aksi validasi tidak dapat diproses. Silakan coba kembali.
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-id-card mr-2"></i>Data Ijazah Mahasiswa
                </h6>
                <small class="text-muted d-none d-md-inline">Klik titik untuk validasi per data &middot; titik tiga untuk aksi semua data</small>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center text-nowrap">No</th>
                                <th class="text-nowrap">NIM</th>
                                <th class="text-nowrap">Nama Mahasiswa</th>
                                <th class="text-nowrap">NIK</th>
                                <th>Tempat<br>Lahir</th>
                                <th>Tgl<br>Lahir</th>
                                <th>Prodi</th>
                                @foreach ($statusFields as $label)
                                    <th class="text-center text-nowrap">{{ $label }}</th>
                                @endforeach
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ijazahs as $ijazah)
                                @php
                                    $tanggalLahir = $ijazah->tanggal_lahir;
                                    if ($tanggalLahir instanceof \DateTimeInterface) {
                                        $tanggalLahir = $tanggalLahir->format('d-m-Y');
                                    }
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-nowrap">{{ $ijazah->user->username ?? $ijazah->nim }}</td>
                                    <td>{{ $ijazah->user->name ?? '-' }}</td>
                                    <td class="text-nowrap">{{ $ijazah->nik }}</td>
                                    <td>{{ $ijazah->tempat_lahir }}</td>
                                    <td class="text-nowrap">{{ $tanggalLahir ?: '-' }}</td>
                                    <td>{{ $ijazah->prodi }}</td>

                                    @foreach ($statusFields as $field => $label)
                                        @php
                                            $status = $ijazah->{'validasi_' . $field};
                                            $dot = $statusDots[$status] ?? ['color' => '#858796', 'label' => 'Menunggu validasi'];
                                        @endphp
                                        <td class="text-center align-middle">
                                            <div class="dropdown d-inline-block">
                                                <button
                                                    class="btn btn-sm p-1"
                                                    type="button"
                                                    id="statusIjazah{{ $ijazah->id }}{{ $field }}"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    title="{{ $label }}: {{ $dot['label'] }}. Klik untuk mengubah."
                                                >
                                                    <span
                                                        class="d-inline-block rounded-circle"
                                                        style="width: 16px; height: 16px; background-color: {{ $dot['color'] }};"
                                                        aria-label="{{ $label }}: {{ $dot['label'] }}"
                                                    ></span>
                                                </button>

                                                <div class="dropdown-menu" aria-labelledby="statusIjazah{{ $ijazah->id }}{{ $field }}">
                                                    <h6 class="dropdown-header">{{ $label }}</h6>
                                                    <form method="POST" action="{{ route('superadmin.ijazah.validasi', $ijazah) }}">
                                                        @csrf
                                                        <input type="hidden" name="field" value="{{ $field }}">
                                                        <input type="hidden" name="status" value="1">
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="fas fa-check-circle mr-2"></i>Valid
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('superadmin.ijazah.validasi', $ijazah) }}">
                                                        @csrf
                                                        <input type="hidden" name="field" value="{{ $field }}">
                                                        <input type="hidden" name="status" value="2">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-times-circle mr-2"></i>Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    @endforeach

                                    <td class="text-center align-middle">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link btn-sm text-secondary p-0"
                                                type="button"
                                                id="aksiIjazah{{ $ijazah->id }}"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                title="Aksi validasi"
                                            >
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="aksiIjazah{{ $ijazah->id }}">
                                                <form method="POST" action="{{ route('superadmin.ijazah.validasi', $ijazah) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="1">
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="fas fa-check-circle mr-2"></i>Validasi Semua
                                                    </button>
                                                </form>

                                                <div class="dropdown-divider"></div>

                                                <form method="POST" action="{{ route('superadmin.ijazah.validasi', $ijazah) }}" onsubmit="return confirm('Tandai seluruh data Ijazah mahasiswa ini sebagai perlu diperbaiki?');">
                                                    @csrf
                                                    <input type="hidden" name="status" value="2">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-times-circle mr-2"></i>Tolak Semua
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center text-muted py-4">
                                        Belum ada mahasiswa yang mengirim data Ijazah.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
