@extends('layouts.app')

@section('title', 'Validasi Perpustakaan Wisuda')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 mb-1 text-gray-800">
                Validasi Perpustakaan Wisuda
            </h1>

            <p class="mb-0 text-muted">
                Validasi Repository, Tracer Study, dan Bebas Perpustakaan mahasiswa.
            </p>

        </div>

    </div>


    {{-- PESAN SUKSES --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="close"
                data-dismiss="alert"
            >

                <span>&times;</span>

            </button>

        </div>

    @endif


    {{-- TABEL --}}
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                <i class="fas fa-book mr-2"></i>

                Validasi Dokumen Perpustakaan Wisuda

            </h6>

        </div>


        <div class="card-body">

            {{-- FILTER ANGKATAN --}}
            <form method="GET" action="{{ route('superadmin.wisuda.perpustakaan') }}" class="form-inline mb-4 p-2 bg-light rounded border">
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
                    <a href="{{ route('superadmin.wisuda.perpustakaan') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times mr-1"></i> Reset Filter
                    </a>
                @endif
            </form>

            <div class="table-responsive">

                <table
                    class="table table-bordered table-hover"
                    id="dataTable"
                    width="100%"
                    cellspacing="0"
                >

                    <thead class="thead-light">

                        <tr>

                            <th class="text-center">
                                No
                            </th>

                            <th>
                                NIM
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Program Studi
                            </th>

                            <th>
                                Angkatan
                            </th>

                            <th class="text-center">
                                Repository
                            </th>

                            <th class="text-center">
                                Tracer Study
                            </th>

                            <th class="text-center">
                                Bebas Perpus
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($wisudas as $wisuda)

                            <tr>

                                {{-- NO --}}
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- NIM --}}
                                <td>
                                    {{ $wisuda->user->username ?? '-' }}
                                </td>


                                {{-- NAMA --}}
                                <td>
                                    {{ $wisuda->user->name ?? '-' }}
                                </td>


                                {{-- PRODI --}}
                                <td>
                                    {{ $wisuda->user->prodi ?? '-' }}
                                </td>

                                {{-- ANGKATAN --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $wisuda->user->angkatan ?? 'Sebelumnya' }}
                                    </span>
                                </td>


                                {{-- REPOSITORY --}}
                                <td class="text-center">

                                    @if($wisuda->link_repositori)

                                        <a
                                            href="{{ $wisuda->link_repositori }}"
                                            target="_blank"
                                            class="btn btn-sm btn-info mb-2"
                                        >

                                            <i class="fas fa-external-link-alt mr-1"></i>

                                            Lihat Repository

                                        </a>

                                    @else

                                        <span class="text-muted d-block mb-2">
                                            Belum ada
                                        </span>

                                    @endif


                                    {{-- STATUS REPOSITORY --}}

                                    @if($wisuda->validasi_repositori == 1)

                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>
                                            Disetujui
                                        </span>

                                    @elseif($wisuda->validasi_repositori == 2)

                                        <span class="badge badge-danger">
                                            <i class="fas fa-times mr-1"></i>
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock mr-1"></i>
                                            Belum divalidasi
                                        </span>

                                    @endif

{{-- AKSI VALIDASI REPOSITORY --}}
<div class="mt-2">

    {{-- SETUJUI --}}
    <form
        method="POST"
        action="{{ route(
            'superadmin.wisuda.perpustakaan.validasi',
            [
                'id' => $wisuda->id,
                'jenis' => 'repositori'
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
            class="btn btn-sm btn-success"
            title="Setujui Repository"
            onclick="return confirm('Setujui Repository mahasiswa ini?')"
        >
            <i class="fas fa-check"></i>
        </button>

    </form>


    {{-- TOLAK --}}
    <form
        method="POST"
        action="{{ route(
            'superadmin.wisuda.perpustakaan.validasi',
            [
                'id' => $wisuda->id,
                'jenis' => 'repositori'
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
            class="btn btn-sm btn-danger"
            title="Tolak Repository"
            onclick="return confirm('Tolak Repository mahasiswa ini?')"
        >
            <i class="fas fa-times"></i>
        </button>

    </form>

</div>

                                </td>


                                {{-- TRACER STUDY --}}
                                <td class="text-center">

                                    @if($wisuda->link_tracer_study)

                                        <a
                                            href="{{ $wisuda->link_tracer_study }}"
                                            target="_blank"
                                            class="btn btn-sm btn-info mb-2"
                                        >

                                            <i class="fas fa-external-link-alt mr-1"></i>

                                            Lihat Tracer

                                        </a>

                                    @else

                                        <span class="text-muted d-block mb-2">
                                            Belum ada
                                        </span>

                                    @endif


                                    {{-- STATUS TRACER STUDY --}}

                                    @if($wisuda->validasi_tracer_study == 1)

                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>
                                            Disetujui
                                        </span>

                                    @elseif($wisuda->validasi_tracer_study == 2)

                                        <span class="badge badge-danger">
                                            <i class="fas fa-times mr-1"></i>
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock mr-1"></i>
                                            Belum divalidasi
                                        </span>

                                    @endif


                                    {{-- AKSI TRACER STUDY --}}
                                    @if($wisuda->link_tracer_study)

                                        <div class="d-flex justify-content-center mt-2">

                                            {{-- SETUJUI --}}
                                            <form method="POST"
                                                action="{{ route('superadmin.wisuda.perpustakaan.validasi', [
                                                    'id' => $wisuda->id,
                                                    'jenis' => 'tracer_study'
                                                ]) }}"
                                                class="mr-1">

                                                @csrf

                                                <input type="hidden"
                                                    name="status"
                                                    value="1">

                                                <button type="submit"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('Setujui Tracer Study mahasiswa ini?')"
                                                        title="Setujui">

                                                    <i class="fas fa-check"></i>

                                                </button>

                                            </form>


                                            {{-- TOLAK --}}
                                            <form method="POST"
                                                action="{{ route('superadmin.wisuda.perpustakaan.validasi', [
                                                    'id' => $wisuda->id,
                                                    'jenis' => 'tracer_study'
                                                ]) }}"
                                                class="mr-1">

                                                @csrf

                                                <input type="hidden"
                                                    name="status"
                                                    value="2">

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Tolak tracer study mahasiswa ini?')"
                                                        title="Tolak">

                                                    <i class="fas fa-times"></i>

                                                </button>

                                            </form>

                                        </div>

                                    @endif

                                </td>


                                {{-- BEBAS PERPUSTAKAAN --}}
                                <td class="text-center">

                                    @if($wisuda->link_bukti_perpus)

                                        <a
                                            href="{{ $wisuda->link_bukti_perpus }}"
                                            target="_blank"
                                            class="btn btn-sm btn-info mb-2"
                                        >

                                            <i class="fas fa-external-link-alt mr-1"></i>

                                            Lihat Bukti

                                        </a>

                                    @else

                                        <span class="text-muted d-block mb-2">
                                            Belum ada
                                        </span>

                                    @endif


                                   {{-- STATUS BEBAS PERPUSTAKAAN --}}
@if($wisuda->validasi_bebas_perpus_wisuda == 1)

    <span class="badge badge-success">
        <i class="fas fa-check mr-1"></i>
        Disetujui
    </span>

@elseif($wisuda->validasi_bebas_perpus_wisuda == 2)

    <span class="badge badge-danger">
        <i class="fas fa-times mr-1"></i>
        Ditolak
    </span>

@else

    <span class="badge badge-warning">
        <i class="fas fa-clock mr-1"></i>
        Belum divalidasi
    </span>

@endif


{{-- AKSI BEBAS PERPUSTAKAAN --}}
@if($wisuda->link_bukti_perpus)

    <div class="d-flex justify-content-center mt-2">

        {{-- SETUJUI --}}
        <form method="POST"
            action="{{ route('superadmin.wisuda.perpustakaan.validasi', [
                'id' => $wisuda->id,
                'jenis' => 'bebas_perpus'
            ]) }}"
            class="mr-1">

            @csrf

            <input type="hidden"
                   name="status"
                   value="1">

            <button type="submit"
                    class="btn btn-sm btn-success"
                    onclick="return confirm('Setujui bukti bebas perpustakaan mahasiswa ini?')"
                    title="Setujui">

                <i class="fas fa-check"></i>

            </button>

        </form>


        {{-- TOLAK --}}
        <form method="POST"
            action="{{ route('superadmin.wisuda.perpustakaan.validasi', [
                'id' => $wisuda->id,
                'jenis' => 'bebas_perpus'
            ]) }}">

            @csrf

            <input type="hidden"
                   name="status"
                   value="2">

            <button type="submit"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('Tolak bukti bebas perpustakaan mahasiswa ini?')"
                    title="Tolak">

                <i class="fas fa-times"></i>

            </button>

        </form>

    </div>

@endif

</td>

                                   

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="fas fa-info-circle mr-2"></i>

                                    Belum ada data Wisuda.

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