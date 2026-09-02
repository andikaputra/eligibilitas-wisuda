@extends('layouts.app')

@section('title', 'Validasi Keuangan Yudisium')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header">
        <h6 class="font-weight-bold text-primary mb-0">
            Validasi Keuangan Yudisium
        </h6>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTER ANGKATAN --}}
        <form method="GET" action="{{ route('superadmin.yudisium.keuangan') }}" class="form-inline mb-4 p-2 bg-light rounded border">
            <label class="mr-2 font-weight-bold text-dark"><i class="fas fa-filter text-primary mr-1"></i> Filter Angkatan:</label>
            <select name="angkatan" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <option value="">-- Semua Angkatan --</option>
                @foreach($angkatanList ?? [] as $th)
                    <option value="{{ $th }}" {{ ($selectedAngkatan ?? '') == $th ? 'selected' : '' }}>
                        Angkatan {{ $th }}
                    </option>
                @endforeach
                <option value="sebelumnya" {{ ($selectedAngkatan ?? '') == 'sebelumnya' ? 'selected' : '' }}>
                    Angkatan Sebelumnya / Tanpa Angkatan
                </option>
            </select>
            @if(!empty($selectedAngkatan))
                <a href="{{ route('superadmin.yudisium.keuangan') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times mr-1"></i> Reset Filter
                </a>
            @endif
        </form>

        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Prodi</th>
                        <th>Angkatan</th>
                        <th>Pembayaran Alumni</th>
                        <th>Bebas Keuangan</th>
                        <th>Pembayaran Yudisium</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($yudisiums as $yudisium)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $yudisium->user->username ?? $yudisium->user_id }}
                        </td>

                        <td>
                            {{ $yudisium->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $yudisium->user->prodi ?? '-' }}
                        </td>

                        <td>
                            <span class="badge badge-info">
                                {{ $yudisium->angkatan ?? $yudisium->user->angkatan ?? 'Sebelumnya' }}
                            </span>
                        </td>

                        {{-- PEMBAYARAN ALUMNI --}}
                        <td>

                            @if($yudisium->link_pembayaran_alumni)

                                <a href="{{ $yudisium->link_pembayaran_alumni }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm mb-2">
                                    Lihat Dokumen
                                </a>

                                <div>

                                    @if($yudisium->validasi_pembayaran_alumni == 1)

                                        <span class="badge badge-success">
                                            Disetujui
                                        </span>

                                    @elseif($yudisium->validasi_pembayaran_alumni == 2)

                                        <span class="badge badge-danger">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Belum Validasi
                                        </span>

                                    @endif

                                </div>

                                <div class="mt-2">

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'superadmin.yudisium.keuangan.validasi',
                                            [
                                                'id' => $yudisium->id,
                                                'jenis' => 'pembayaran_alumni'
                                            ]
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="1"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm"
                                        >
                                            Validasi
                                        </button>

                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'superadmin.yudisium.keuangan.validasi',
                                            [
                                                'id' => $yudisium->id,
                                                'jenis' => 'pembayaran_alumni'
                                            ]
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="2"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Tolak
                                        </button>

                                    </form>

                                </div>

                            @else

                                <span class="text-muted">
                                    Belum ada dokumen
                                </span>

                            @endif

                        </td>


                        {{-- BEBAS KEUANGAN --}}
                        <td>

                            @if($yudisium->link_bebas_keuangan)

                                <a href="{{ $yudisium->link_bebas_keuangan }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm mb-2">
                                    Lihat Dokumen
                                </a>

                                <div>

                                    @if($yudisium->validasi_bebas_keuangan == 1)

                                        <span class="badge badge-success">
                                            Disetujui
                                        </span>

                                    @elseif($yudisium->validasi_bebas_keuangan == 2)

                                        <span class="badge badge-danger">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Belum Validasi
                                        </span>

                                    @endif

                                </div>

                                <div class="mt-2">

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'superadmin.yudisium.keuangan.validasi',
                                            [
                                                'id' => $yudisium->id,
                                                'jenis' => 'bebas_keuangan'
                                            ]
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="1"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm"
                                        >
                                            Validasi
                                        </button>

                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'superadmin.yudisium.keuangan.validasi',
                                            [
                                                'id' => $yudisium->id,
                                                'jenis' => 'bebas_keuangan'
                                            ]
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="2"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Tolak
                                        </button>

                                    </form>

                                </div>

                            @else

                                <span class="text-muted">
                                    Belum ada dokumen
                                </span>

                            @endif

                        </td>


                        {{-- PEMBAYARAN YUDISIUM --}}
                        <td>

                            @if($yudisium->link_pembayaran_yudisium)

                                <a href="{{ $yudisium->link_pembayaran_yudisium }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm mb-2">
                                    Lihat Dokumen
                                </a>

                                <div>

                                    @if($yudisium->validasi_pembayaran_yudisium == 1)

                                        <span class="badge badge-success">
                                            Disetujui
                                        </span>

                                    @elseif($yudisium->validasi_pembayaran_yudisium == 2)

                                        <span class="badge badge-danger">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Belum Validasi
                                        </span>

                                    @endif

                                </div>

                                <div class="mt-2">

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'superadmin.yudisium.keuangan.validasi',
                                            [
                                                'id' => $yudisium->id,
                                                'jenis' => 'pembayaran_yudisium'
                                            ]
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="1"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm"
                                        >
                                            Validasi
                                        </button>

                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'superadmin.yudisium.keuangan.validasi',
                                            [
                                                'id' => $yudisium->id,
                                                'jenis' => 'pembayaran_yudisium'
                                            ]
                                        ) }}"
                                        class="d-inline"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="2"
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Tolak
                                        </button>

                                    </form>

                                </div>

                            @else

                                <span class="text-muted">
                                    Belum ada dokumen
                                </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection