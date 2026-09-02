@extends('layouts.app')

@section('title', 'Siap Yudisium')

@section('content')

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user-graduate mr-1"></i>
            Siap Yudisium
        </h6>

    </div>


    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 p-2 bg-light rounded border">
            {{-- FILTER ANGKATAN --}}
            <form method="GET" action="{{ route('superadmin.yudisium.siap') }}" class="form-inline mb-2 mb-md-0">
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
                    <a href="{{ route('superadmin.yudisium.siap') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times mr-1"></i> Reset Filter
                    </a>
                @endif
            </form>

            <a
                href="{{ route('superadmin.yudisium.cetakSemua', ['angkatan' => $selectedAngkatan]) }}"
                target="_blank"
                class="btn btn-success"
            >
                <i class="fas fa-print mr-1"></i>
                Cetak Semua Kartu
            </a>
        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover" id="dataTable">

                <thead class="thead-light">

                    <tr>

                        <th class="text-center">
                            No
                        </th>

                        <th class="text-center">
                            No. Urut
                        </th>

                        <th>
                            NIM
                        </th>

                        <th>
                            Nama Mahasiswa
                        </th>

                        <th>
                            Prodi
                        </th>

                        <th>
                            Angkatan
                        </th>

                        <th class="text-center">
                            Foto
                        </th>

                        <th class="text-center">
                            Pembayaran Alumni
                        </th>

                        <th class="text-center">
                            Bebas Keuangan
                        </th>

                        <th class="text-center">
                            Pembayaran Yudisium
                        </th>

                        <th class="text-center">
                            Artikel / LOA
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

                    @forelse($yudisiums as $yudisium)

                        <tr>

                            {{-- NO --}}

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>


{{-- NO URUT --}}
<td class="text-center">

    <form method="POST"
          action="{{ route('superadmin.yudisium.noUrut', $yudisium->id) }}">

        @csrf

        <div class="input-group input-group-sm">

            <input
                type="number"
                name="no_urut"
                value="{{ $yudisium->no_urut }}"
                min="1"
                class="form-control"
                style="width: 70px;"
                required
            >

            <div class="input-group-append">

                <button
                    type="submit"
                    class="btn btn-primary"
                    title="Simpan Nomor Urut"
                >

                    <i class="fas fa-save"></i>

                </button>

            </div>

        </div>

    </form>

</td>


                            {{-- NIM --}}

                            <td>
                                {{ $yudisium->user->username ?? '-' }}
                            </td>


                            {{-- NAMA --}}

                            <td>
                                {{ $yudisium->user->name ?? '-' }}
                            </td>


                            {{-- PRODI --}}

                            <td>
                                {{ $yudisium->user->prodi ?? '-' }}
                            </td>

                            {{-- ANGKATAN --}}
                            <td>
                                <span class="badge badge-info">
                                    {{ $yudisium->angkatan ?? $yudisium->user->angkatan ?? 'Sebelumnya' }}
                                </span>
                            </td>


                            {{-- FOTO --}}

                            <td class="text-center">

                                @if($yudisium->validasi_foto == 1)

                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                        OK
                                    </span>

                                @elseif($yudisium->validasi_foto == 2)

                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Belum
                                    </span>

                                @endif

                            </td>


                            {{-- PEMBAYARAN ALUMNI --}}

                            <td class="text-center">

                                @if($yudisium->validasi_pembayaran_alumni == 1)

                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                        OK
                                    </span>

                                @elseif($yudisium->validasi_pembayaran_alumni == 2)

                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Belum
                                    </span>

                                @endif

                            </td>


                            {{-- BEBAS KEUANGAN --}}

                            <td class="text-center">

                                @if($yudisium->validasi_bebas_keuangan == 1)

                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                        OK
                                    </span>

                                @elseif($yudisium->validasi_bebas_keuangan == 2)

                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Belum
                                    </span>

                                @endif

                            </td>


                            {{-- PEMBAYARAN YUDISIUM --}}

                            <td class="text-center">

                                @if($yudisium->validasi_pembayaran_yudisium == 1)

                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                        OK
                                    </span>

                                @elseif($yudisium->validasi_pembayaran_yudisium == 2)

                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Belum
                                    </span>

                                @endif

                            </td>


                            {{-- ARTIKEL / LOA --}}

                            <td class="text-center">

                                @if($yudisium->validasi_artikel_loa == 1)

                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                        OK
                                    </span>

                                @elseif($yudisium->validasi_artikel_loa == 2)

                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Belum
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS KESELURUHAN --}}

                            <td class="text-center">

                                @php

                                    $siap =
                                        $yudisium->validasi_foto == 1 &&
                                        $yudisium->validasi_pembayaran_alumni == 1 &&
                                        $yudisium->validasi_bebas_keuangan == 1 &&
                                        $yudisium->validasi_pembayaran_yudisium == 1 &&
                                        $yudisium->validasi_artikel_loa == 1;

                                @endphp


                                @if($siap)

                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i>
                                        SIAP YUDISIUM
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        BELUM SIAP
                                    </span>

                                @endif

                            </td>


                             {{-- STATUS KESELURUHAN --}}
                            <td class="text-center">

                            <a
                                href="{{ route('superadmin.yudisium.cetakKartu', $yudisium->id) }}"
                                target="_blank"
                                class="btn btn-primary btn-sm"
                                title="Cetak Kartu Yudisium"
                            >
                                <i class="fas fa-print mr-1"></i>
                                Cetak Kartu
                            </a>

                        </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="11" class="text-center text-muted">

                                Belum ada data Yudisium.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection