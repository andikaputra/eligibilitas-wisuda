@extends('layouts.app')

@section('title', 'Siap Wisuda')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Siap Wisuda
            </h1>

        

            <p class="mb-0 text-muted">
                Monitoring persyaratan dan nomor urut Wisuda mahasiswa.
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

                <i class="fas fa-graduation-cap mr-2"></i>

                Daftar Siap Wisuda

            </h6>

        </div>


        <div class="card-body">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 p-2 bg-light rounded border">
        {{-- FILTER ANGKATAN --}}
        <form method="GET" action="{{ route('superadmin.wisuda.siap') }}" class="form-inline mb-2 mb-md-0">
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
                <a href="{{ route('superadmin.wisuda.siap') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times mr-1"></i> Reset Filter
                </a>
            @endif
        </form>

        {{-- TOMBOL CETAK SEMUA --}}
        <a
            href="{{ route('superadmin.wisuda.cetakSemua') }}"
            target="_blank"
            class="btn btn-primary btn-sm"
        >
            <i class="fas fa-print mr-1"></i>
            Cetak Semua Kartu
        </a>

    </div>

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
                                Keuangan
                            </th>

                            <th class="text-center">
                                Repository
                            </th>

                            <th class="text-center">
                                Tracer Study
                            </th>

                            <th class="text-center">
                                Perpustakaan
                            </th>

                            <th class="text-center">
                                No. Urut
                            </th>

                            <th class="text-center">
                                Aksi
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


                                {{-- KEUANGAN --}}
                                <td class="text-center">

                                    @if($wisuda->validasi_pembayaran_wisuda == 1)

                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i>
                                            Disetujui
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Belum
                                        </span>

                                    @endif

                                </td>


                                {{-- REPOSITORY --}}
                                <td class="text-center">

                                    @if($wisuda->validasi_repositori == 1)

                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i>
                                            Disetujui
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Belum
                                        </span>

                                    @endif

                                </td>


                                {{-- TRACER STUDY --}}
                                <td class="text-center">

                                    @if($wisuda->validasi_tracer_study == 1)

                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i>
                                            Disetujui
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Belum
                                        </span>

                                    @endif

                                </td>


                                {{-- PERPUSTAKAAN --}}
                                <td class="text-center">

                                    @if($wisuda->validasi_bebas_perpus_wisuda == 1)

                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i>
                                            Disetujui
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Belum
                                        </span>

                                    @endif

                                </td>


                                {{-- NO URUT --}}
                                <td class="text-center">

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'superadmin.wisuda.no-urut',
                                            $wisuda->id
                                        ) }}"
                                        class="d-flex justify-content-center"
                                    >

                                        @csrf

                                        <input
                                            type="number"
                                            name="no_urut"
                                            value="{{ $wisuda->no_urut }}"
                                            min="1"
                                            class="form-control form-control-sm mr-1"
                                            style="width: 80px;"
                                            placeholder="No"
                                            required
                                        >

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-primary"
                                            title="Simpan Nomor Urut"
                                        >

                                            <i class="fas fa-save"></i>

                                        </button>

                                    </form>

                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">

                                    @if($wisuda->no_urut)

                                        <a
                                            href="{{ route(
                                                'superadmin.wisuda.cetakKartu',
                                                $wisuda->id
                                            ) }}"
                                            target="_blank"
                                            class="btn btn-sm btn-info"
                                            title="Cetak Kartu Wisuda"
                                        >

                                            <i class="fas fa-id-card mr-1"></i>
                                            Cetak Kartu

                                        </a>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="10"
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