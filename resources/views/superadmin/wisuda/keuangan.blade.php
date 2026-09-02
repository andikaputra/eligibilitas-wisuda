@extends('layouts.app')

@section('title', 'Validasi Keuangan Wisuda')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Validasi Keuangan Wisuda
            </h1>

            <p class="mb-0 text-muted">
                Validasi pembayaran Wisuda mahasiswa.
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

                <i class="fas fa-money-bill-wave mr-2"></i>

                Daftar Pembayaran Wisuda

            </h6>

        </div>


        <div class="card-body">

            {{-- FILTER ANGKATAN --}}
            <form method="GET" action="{{ route('superadmin.wisuda.keuangan') }}" class="form-inline mb-4 p-2 bg-light rounded border">
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
                    <a href="{{ route('superadmin.wisuda.keuangan') }}" class="btn btn-sm btn-outline-secondary">
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
                                Bukti Pembayaran
                            </th>

                            <th class="text-center">
                                Status
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


                                {{-- BUKTI PEMBAYARAN --}}

                                <td class="text-center">

                                    @if($wisuda->link_pembayaran_wisuda)

                                        <a
                                            href="{{ $wisuda->link_pembayaran_wisuda }}"
                                            target="_blank"
                                            class="btn btn-sm btn-info"
                                        >

                                            <i class="fas fa-external-link-alt mr-1"></i>

                                            Lihat Bukti

                                        </a>

                                    @else

                                        <span class="text-muted">
                                            Belum ada
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}

                                <td class="text-center">

                                    @if($wisuda->validasi_pembayaran_wisuda == 1)

                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>
                                            Disetujui
                                        </span>

                                    @elseif($wisuda->validasi_pembayaran_wisuda == 2)

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

                                </td>


                                {{-- AKSI --}}

                                <td class="text-center">

                                    <div class="d-flex justify-content-center">

                                        {{-- SETUJUI --}}

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'superadmin.wisuda.keuangan.validasi',
                                                $wisuda->id
                                            ) }}"
                                            class="mr-1"
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
                                                onclick="return confirm('Setujui pembayaran Wisuda mahasiswa ini?')"
                                                title="Setujui"
                                            >

                                                <i class="fas fa-check"></i>

                                            </button>

                                        </form>


                                        {{-- TOLAK --}}

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'superadmin.wisuda.keuangan.validasi',
                                                $wisuda->id
                                            ) }}"
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
                                                onclick="return confirm('Tolak pembayaran Wisuda mahasiswa ini?')"
                                                title="Tolak"
                                            >

                                                <i class="fas fa-times"></i>

                                            </button>

                                        </form>

                                    </div>

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