@extends('layouts.app')

@section('title', 'Validasi Pembayaran')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header">
    <h6 class="font-weight-bold text-primary">Daftar Wisuda - Siap Wisuda</h6>
  </div>
  <div class="card-body">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="dataTable">
      <thead>
        <tr>
            <th>Photo</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Prodi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($wisudas as $wisuda)
        <tr>
            <td>{{$wisuda->link_bukti_pembayaran}}</td>

            <td>{{ $wisuda->user->username }}</td>
            <td>{{ $wisuda->user->name }}</td>
            <td>{{ $wisuda->user->prodi }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
