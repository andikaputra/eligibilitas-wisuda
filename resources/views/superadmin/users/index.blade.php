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
    <table class="table table-bordered">
        <thead >
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Prodi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $d)
            @if($d->role == "mahasiswa")
                <tr>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->prodi}}</td>
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>

</div>
@endsection
