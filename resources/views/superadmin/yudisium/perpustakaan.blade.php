@extends('layouts.app')

@section('title', 'Validasi Perpustakaan Yudisium')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header">
        <h6 class="font-weight-bold text-primary">
            Validasi Perpustakaan - Yudisium
        </h6>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTER ANGKATAN --}}
        <form method="GET" action="{{ route('superadmin.yudisium.perpustakaan') }}" class="form-inline mb-4 p-2 bg-light rounded border">
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
                <a href="{{ route('superadmin.yudisium.perpustakaan') }}" class="btn btn-sm btn-outline-secondary">
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
                        <th>Foto</th>
                        <th>Artikel / LOA</th>
                        <th>Status Foto</th>
                        <th>Status Artikel / LOA</th>
                        <th>Aksi</th>
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


                        {{-- FOTO --}}

                        <td>

                            @if($yudisium->link_foto)

                                <a href="{{ $yudisium->link_foto }}"
                                   target="_blank"
                                   class="btn btn-primary btn-sm">

                                    <i class="fas fa-eye"></i>
                                    Lihat Foto

                                </a>

                            @else

                                <span class="text-muted">
                                    Belum ada
                                </span>

                            @endif

                        </td>


                        {{-- ARTIKEL / LOA --}}

                        <td>

                            @if($yudisium->link_artikel_loa)

                                <a href="{{ $yudisium->link_artikel_loa }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm">

                                    <i class="fas fa-newspaper"></i>
                                    Lihat Artikel / LOA

                                </a>

                            @else

                                <span class="text-muted">
                                    Belum ada
                                </span>

                            @endif

                        </td>


                        {{-- STATUS FOTO --}}

                        <td>

                            @if($yudisium->validasi_foto == 1)

                                <span class="badge badge-success">
                                    Disetujui
                                </span>

                            @elseif($yudisium->validasi_foto == 2)

                                <span class="badge badge-danger">
                                    Ditolak
                                </span>

                            @else

                                <span class="badge badge-warning">
                                    Belum Divalidasi
                                </span>

                            @endif

                        </td>


                        {{-- STATUS ARTIKEL / LOA --}}

                        <td>

                            @if($yudisium->validasi_artikel_loa == 1)

                                <span class="badge badge-success">
                                    Disetujui
                                </span>

                            @elseif($yudisium->validasi_artikel_loa == 2)

                                <span class="badge badge-danger">
                                    Ditolak
                                </span>

                            @else

                                <span class="badge badge-warning">
                                    Belum Divalidasi
                                </span>

                            @endif

                        </td>


                        {{-- AKSI --}}

                        <td>

                            {{-- VALIDASI FOTO --}}

                            <div class="mb-3">

                                <small class="font-weight-bold d-block mb-1">
                                    Foto
                                </small>

                                <div class="d-flex">

                                    {{-- SETUJUI FOTO --}}

                                    <form method="POST"
                                          action="{{ route('superadmin.yudisium.perpustakaan.validasi', $yudisium->id) }}"
                                          class="mr-2">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="1">

                                        <input type="hidden"
                                               name="target"
                                               value="foto">

                                        <button type="submit"
                                                class="btn btn-success btn-sm">

                                            <i class="fas fa-check"></i>

                                        </button>

                                    </form>


                                    {{-- TOLAK FOTO --}}

                                    <form method="POST"
                                          action="{{ route('superadmin.yudisium.perpustakaan.validasi', $yudisium->id) }}">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="2">

                                        <input type="hidden"
                                               name="target"
                                               value="foto">

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">

                                            <i class="fas fa-times"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>


                            {{-- VALIDASI ARTIKEL / LOA --}}

                            <div>

                                <small class="font-weight-bold d-block mb-1">
                                    Artikel / LOA
                                </small>

                                <div class="d-flex">

                                    {{-- SETUJUI ARTIKEL --}}

                                    <form method="POST"
                                          action="{{ route('superadmin.yudisium.perpustakaan.validasi', $yudisium->id) }}"
                                          class="mr-2">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="1">

                                        <input type="hidden"
                                               name="target"
                                               value="artikel">

                                        <button type="submit"
                                                class="btn btn-success btn-sm">

                                            <i class="fas fa-check"></i>

                                        </button>

                                    </form>


                                    {{-- TOLAK ARTIKEL --}}

                                    <form method="POST"
                                          action="{{ route('superadmin.yudisium.perpustakaan.validasi', $yudisium->id) }}">

                                        @csrf

                                        <input type="hidden"
                                               name="status"
                                               value="2">

                                        <input type="hidden"
                                               name="target"
                                               value="artikel">

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">

                                            <i class="fas fa-times"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection