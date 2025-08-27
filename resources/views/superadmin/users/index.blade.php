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

  <a href="{{ route('users.create') }}" class="btn btn-primary mb-4">Tambah User</a>
    <table class="table table-bordered" id="dataTable">
        <thead >
            <tr>
                <th>Tanggal</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Kirim Notifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $d)
            @if($d->role == "mahasiswa")
                <tr>
                    <td>{{ $d->created_at }}</td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->prodi}}</td>
                    <td>    
                        <a href="https://wa.me/{{ $d->wa }}?text=Kami%20dari%20panitia%20Wisuda%0AMohon%20lengkapi%20data%20pendaftaran%20wisuda%20anda%20melalui%20link%20wisuda.markandeyabali.ac.id%0Amenggunakan%0Auser%20:%20nim%20anda%0Apassword%20:%20nim%20anda%0Aterima%20kasih" " target="_blank" class="btn btn-success btn-sm">Chat WA</a></td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>

</div>
@endsection
