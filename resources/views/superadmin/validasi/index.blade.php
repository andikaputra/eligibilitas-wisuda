@extends('layouts.app')

@section('title', 'Siap Wisuda')

@section('content')

<div class="card shadow mb-4">

<div class="card-header">
    <h6 class="font-weight-bold text-primary">
        Daftar Wisuda - Siap Wisuda
    </h6>
</div>

<div class="card-body">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <a href="{{ route('wisuda.exportPdf') }}" class="btn btn-danger mb-2 mb-md-0">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
        </a>

        {{-- FILTER ANGKATAN --}}
        <form method="GET" action="{{ route('superadmin.validasi.index') }}" class="form-inline">
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
                <a href="{{ route('superadmin.validasi.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times mr-1"></i> Reset
                </a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Prodi</th>
                    <th>Angkatan</th>
                    <th>No. Urut Peserta</th>
                </tr>
            </thead>

            <tbody>

                @foreach($wisudas as $wisuda)

                <tr>

                    {{-- Nomor data --}}
                    <td>
                        {{ $loop->iteration }}
                    </td>

                    {{-- Photo --}}
                    <td>
                        <a href="{{ $wisuda->link_bukti_pembayaran }}"
                           target="_blank"
                           class="btn btn-primary btn-sm">
                            Lihat Foto
                        </a>
                    </td>

                    {{-- NIM --}}
                    <td>
                        {{ $wisuda->user->username }}
                    </td>

                    {{-- Nama --}}
                    <td>
                        {{ $wisuda->user->name }}
                    </td>

                    {{-- Prodi --}}
                    <td>
                        {{ $wisuda->user->prodi }}
                    </td>

                    {{-- Angkatan --}}
                    <td>
                        <span class="badge badge-info">
                            {{ $wisuda->user->angkatan ?? 'Sebelumnya' }}
                        </span>
                    </td>

                    {{-- No Urut Peserta --}}
                    <td>

                        <form method="POST"
                              action="{{ route('superadmin.validasi.noUrut', $wisuda->id) }}"
                              class="d-flex">

                            @csrf

                            <input
                                type="number"
                                name="no_urut"
                                class="form-control form-control-sm"
                                min="1"
                                value="{{ $wisuda->no_urut }}"
                                placeholder="No. urut"
                                required
                            >

                            <button type="submit"
                                    class="btn btn-success btn-sm ml-2">
                                Simpan
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>
    </div>

</div>
```

</div>
@endsection
