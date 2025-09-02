@extends('layouts.app')

@section('title', 'Siap Wisuda')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header">
    <h6 class="font-weight-bold text-primary">Daftar Wisuda - Siap Wisuda</h6>
  </div>
  <div class="card-body">

  <div class="mb-3">
    <a href="{{ route('wisuda.exportPdf') }}" class="btn btn-danger">
        Export PDF
    </a>
</div> 

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
            <td>        
            <a href="{{ $wisuda->link_bukti_pembayaran }}" 
              target="_blank" 
              class="btn btn-primary btn-sm">
            Lihat Foto
            </a>
            </td>

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
