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
      <!-- Link pasphoto -->
      <div class="mb-3">
        <label for="link_bukti_pembayaran" class="form-label">Link Pas Photo</label>
        <p class="alert alert-primary d-block mb-3">
          masukkan link dari google drive dan pastikan sudah di share (File sudah di-share: Anyone with the link → Viewer)
        </p> 
        <input type="url" class="form-control @error('link_bukti_pembayaran') is-invalid @enderror" id="link_bukti_pembayaran"
          name="link_bukti_pembayaran" required value="{{ old('link_bukti_pembayaran', $data->link_bukti_pembayaran ?? '') }}">
        @error('link_bukti_pembayaran')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if(!empty($data->link_bukti_pembayaran))
        <div class="mt-2">
          <a href="{{ $data->link_bukti_pembayaran }}" target="_blank" class="btn btn-info w-100">Cek pasphoto</a>
        </div>
        @endif
      </div>
      <!-- Link Repositori -->
      <div class="mb-3">
        <label for="link_repositori" class="form-label">Link Repositori</label>
        <p class="alert alert-primary d-block mb-3">
          masukkan link Skripsi yang sudah di publikasi di repo.markandeyabali.ac.id
        </p> 
        <input type="url" class="form-control @error('link_repositori') is-invalid @enderror" id="link_repositori"
          name="link_repositori" required value="{{ old('link_repositori', $data->link_repositori ?? '') }}">
        @error('link_repositori')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if(!empty($data->link_repositori))
        <div class="mt-2">
          <a href="{{ $data->link_repositori }}" target="_blank" class="btn btn-info w-100">Cek Repositori</a>
        </div>
        @endif
      </div>

      <!-- Link Publish Jurnal -->
      <div class="mb-3">
        <label for="link_publish_jurnal" class="form-label">Link Publish Jurnal</label>
        <p class="alert alert-primary d-block mb-3">
          masukkan link jurnal yang sudah publish atau LOA
        </p> 
        <input type="url" class="form-control @error('link_publish_jurnal') is-invalid @enderror"
          id="link_publish_jurnal" name="link_publish_jurnal" required
          value="{{ old('link_publish_jurnal', $data->link_publish_jurnal ?? '') }}">
        @error('link_publish_jurnal')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if(!empty($data->link_publish_jurnal))
        <div class="mt-2">
          <a href="{{ $data->link_publish_jurnal }}" target="_blank" class="btn btn-info w-100">Cek Publish Jurnal</a>
        </div>
        @endif
      </div>

      <!-- Link Bukti Skripsi -->
      <div class="mb-3">
        <label for="link_bukti_skripsi" class="form-label">Link Bukti Pengumpulan Skripsi</label>
        <input type="url" class="form-control @error('link_bukti_skripsi') is-invalid @enderror"
          id="link_bukti_skripsi" name="link_bukti_skripsi" required
          value="{{ old('link_bukti_skripsi', $data->link_bukti_skripsi ?? '') }}">
        @error('link_bukti_skripsi')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if(!empty($data->link_bukti_skripsi))
        <div class="mt-2">
          <a href="{{ $data->link_bukti_skripsi }}" target="_blank" class="btn btn-info w-100">Cek Bukti Skripsi</a>
        </div>
        @endif
      </div>

      <!-- Link Bukti Perpus -->
      <div class="mb-3">
        <label for="link_bukti_perpus" class="form-label">Link Bukti Bebas Perpus</label>
        <input type="url" class="form-control @error('link_bukti_perpus') is-invalid @enderror"
          id="link_bukti_perpus" name="link_bukti_perpus" required
          value="{{ old('link_bukti_perpus', $data->link_bukti_perpus ?? '') }}">
        @error('link_bukti_perpus')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if(!empty($data->link_bukti_perpus))
        <div class="mt-2">
          <a href="{{ $data->link_bukti_perpus }}" target="_blank" class="btn btn-info w-100">Cek Bukti Perpus</a>
        </div>
        @endif
      </div>

      <!-- Tombol Simpan -->
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
