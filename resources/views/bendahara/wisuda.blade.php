@extends('layouts.app')

@section('title', 'Validasi Pembayaran')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header">
    <h6 class="font-weight-bold text-primary">Daftar Wisuda - Validasi Pembayaran</h6>
  </div>
  <div class="card-body">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama Mahasiswa</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($wisudaList as $wisuda)
        <tr>
          <td>{{ $wisuda->user->name }}</td>
          <td>
            @if($wisuda->validasi_bendahara)
              <span class="badge bg-success">Tervalidasi Bayar</span>
            @else
              <span class="badge bg-warning text-dark">Belum</span>
            @endif
          </td>
          <td>
            @if(!$wisuda->validasi_bendahara)
            <form action="{{ route('bendahara.wisuda.validasi', $wisuda->id) }}" method="POST">
              @csrf
              <button class="btn btn-success btn-sm" type="submit">Validasi</button>
            </form>
            @else
              -
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
