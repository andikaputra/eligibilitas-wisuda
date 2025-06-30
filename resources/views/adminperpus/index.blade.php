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

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>LINK</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $wisuda)
                    <tr>
                        <td>{{ $wisuda->id }}</td>
                        <td>{{ $wisuda->user->username }}</td>
                        <td>{{ $wisuda->user->name }}</td>
                        <td>
                            <div class="mb-2">
                                <a class="btn btn-primary w-100" href="{{ $wisuda->link_repositori }}" target="_blank">CEK REPO</a>
                            </div>
                            <div class="mb-2">
                                <a class="btn btn-primary w-100" href="{{ $wisuda->link_publish_jurnal }}" target="_blank">CEK JURNAL</a>
                            </div>
                            <div class="mb-2">
                                <a class="btn btn-primary w-100" href="{{ $wisuda->link_bukti_skripsi }}" target="_blank">CEK BUKTI SKRIPSI</a>
                            </div>
                            <div class="mb-2">
                                <a class="btn btn-primary w-100" href="{{ $wisuda->link_bukti_perpus }}" target="_blank">CEK BUKTI PERPUS</a>
                            </div>
                        </td>

                        <td>
                            <div class="mb-2">
                                <strong>Repository:</strong> 
                                <span class="{{ $wisuda->validasi_repo == '1' ? 'badge bg-success' : 'badge bg-warning text-dark' }}">
                                    {{ $wisuda->validasi_repo == '1' ? 'Sudah divalidasi' : 'Belum divalidasi' }}
                                </span>
                            </div>
                            
                            <div class="mb-2">
                                <strong>Jurnal:</strong> 
                                <span class="{{ $wisuda->validasi_jurnal == '1' ? 'badge bg-success' : 'badge bg-warning text-dark' }}">
                                    {{ $wisuda->validasi_jurnal == '1' ? 'Sudah Tervalidasi' : 'Belum divalidasi' }}
                                </span>
                            </div>
                            
                            <div class="mb-2">
                                <strong>Skripsi:</strong> 
                                <span class="{{ $wisuda->validasi_skripsi == '1' ? 'badge bg-success' : 'badge bg-warning text-dark' }}">
                                    {{ $wisuda->validasi_skripsi == '1' ? 'Sudah Tervalidasi' : 'Belum divalidasi' }}
                                </span>
                            </div>
                            
                            <div class="mb-2">
                                <strong>Bebas Perpus:</strong> 
                                <span class="{{ $wisuda->validasi_perpus == '1' ? 'badge bg-success' : 'badge bg-warning text-dark' }}">
                                    {{ $wisuda->validasi_perpus == '1' ? 'Sudah Tervalidasi' : 'Belum divalidasi' }}
                                </span>
                            </div>
                        </td>
                        
                        <td>
                            <div class="mb-2">
                                @if($wisuda->validasi_repo != 1)
                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasirepo', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Validasi Repo</button>
                                    </form>
                                @else
                                    <span class="text-success">-</span>
                                @endif
                            </div>

                            <div class="mb-2">
                                @if($wisuda->validasi_jurnal != 1)
                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasijurnal', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Validasi Jurnal</button>
                                    </form>
                                @else
                                    <span class="text-success">-</span>
                                @endif
                            </div>

                            <div class="mb-2">
                                @if($wisuda->validasi_skripsi != 1)
                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasiskripsi', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Validasi Skripsi</button>
                                    </form>
                                @else
                                    <span class="text-success">-</span>
                                @endif
                            </div>

                            <div class="mb-2">
                                @if($wisuda->validasi_perpus != 1)
                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasiperpus', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Validasi Bebas Perpus</button>
                                    </form>
                                @else
                                    <span class="text-success">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
