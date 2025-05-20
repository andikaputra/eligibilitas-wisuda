@extends('layouts.app')

@section('title', 'Input Bukti Wisuda')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Input Bukti Wisuda</h6>
  </div>
  <div class="card-body">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('mahasiswa.wisuda.store') }}">
      @csrf
      @php
      $data = $data ?? null;
      @endphp

      <div class="mb-3">
        <label for="link_bukti_pembayaran" class="form-label">Link Bukti Pembayaran</label>
        <input type="url" class="form-control @error('link_bukti_pembayaran') is-invalid @enderror"
          id="link_bukti_pembayaran" name="link_bukti_pembayaran" required
          value="{{ old('link_bukti_pembayaran', $data->link_bukti_pembayaran ?? '') }}">
        @error('link_bukti_pembayaran')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="link_repositori" class="form-label">Link Repositori</label>
        <input type="url" class="form-control @error('link_repositori') is-invalid @enderror" id="link_repositori"
          name="link_repositori" required value="{{ old('link_repositori', $data->link_repositori ?? '') }}">
        @error('link_repositori')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="link_publish_jurnal" class="form-label">Link Publish Jurnal</label>
        <input type="url" class="form-control @error('link_publish_jurnal') is-invalid @enderror"
          id="link_publish_jurnal" name="link_publish_jurnal" required
          value="{{ old('link_publish_jurnal', $data->link_publish_jurnal ?? '') }}">
        @error('link_publish_jurnal')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="link_bukti_skripsi" class="form-label">Link Bukti Ngumpul Skripsi</label>
        <input type="url" class="form-control @error('link_bukti_skripsi') is-invalid @enderror"
          id="link_bukti_skripsi" name="link_bukti_skripsi" required
          value="{{ old('link_bukti_skripsi', $data->link_bukti_skripsi ?? '') }}">
        @error('link_bukti_skripsi')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="link_bukti_perpus" class="form-label">Link Bukti Bebas Perpus</label>
        <input type="url" class="form-control @error('link_bukti_perpus') is-invalid @enderror"
          id="link_bukti_perpus" name="link_bukti_perpus" required
          value="{{ old('link_bukti_perpus', $data->link_bukti_perpus ?? '') }}">
        @error('link_bukti_perpus')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
