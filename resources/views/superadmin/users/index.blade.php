@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header">
    <h6 class="font-weight-bold text-primary">Daftar Wisuda - Validasi Pembayaran</h6>
  </div>
  <div class="card-body">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<span class="alert alert-primary d-block mb-3">
  Pastikan Menambahkan Mahasiswa yang sudah melunasi pembayaran
</span> 

  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-2 mb-md-0">Tambah User</a>

    {{-- FILTER ANGKATAN --}}
    <form method="GET" action="{{ route('users.index') }}" class="form-inline">
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
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times mr-1"></i> Reset
            </a>
        @endif
    </form>
  </div>

    <table class="table table-bordered" id="dataTable">
        <thead>
        <tr>

            <th>Tanggal</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Prodi</th>
            <th>Angkatan</th>
            <th>Kirim Notifikasi</th>
            <th class="text-center">Aksi</th>

        </tr>

        </thead>
        <tbody>

    @foreach($users as $d)

        @if($d->role == "mahasiswa")

            <tr>

                {{-- TANGGAL --}}
                <td>
                    {{ $d->created_at }}
                </td>

                {{-- NIM --}}
                <td>
                    {{ $d->username }}
                </td>

                {{-- NAMA --}}
                <td>
                    {{ $d->name }}
                </td>

                {{-- PRODI --}}
                <td>
                    {{ $d->prodi }}
                </td>

                {{-- ANGKATAN --}}
                <td>
                    <span class="badge badge-info">
                        {{ $d->angkatan ?? 'Sebelumnya' }}
                    </span>
                </td>

                {{-- CHAT WA --}}
                <td>

                    <a href="https://wa.me/{{ $d->wa }}?text=Kami%20dari%20panitia%20Wisuda%0AMohon%20lengkapi%20data%20pendaftaran%20wisuda%20anda%20melalui%20link%20wisuda.markandeyabali.ac.id%0Amenggunakan%0Auser%20:%20nim%20anda%0Apassword%20:%20nim%20anda%0Aterima%20kasih"
                       target="_blank"
                       class="btn btn-success btn-sm">

                        <i class="fab fa-whatsapp mr-1"></i>
                        Chat WA

                    </a>

                </td>

                {{-- AKSI --}}
                <td class="text-center">

                    {{-- RESET PASSWORD --}}
                    <form
                        action="{{ route('users.resetPassword', $d->id) }}"
                        method="POST"
                        style="display:inline-block;"
                        onsubmit="return confirm('Reset password {{ $d->name }} kembali ke NIM {{ $d->username }}?');"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-warning btn-sm"
                            title="Reset Password"
                        >

                            <i class="fas fa-key mr-1"></i>
                            Reset

                        </button>

                    </form>


                    {{-- HAPUS AKUN --}}
                    <form
                        action="{{ route('users.destroy', $d->id) }}"
                        method="POST"
                        style="display:inline-block;"
                        onsubmit="return confirm('Yakin ingin menghapus akun {{ $d->name }}?');"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            title="Hapus Akun"
                        >

                            <i class="fas fa-trash mr-1"></i>
                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

        @endif

    @endforeach

</tbody>
    </table>

</div>
@endsection
