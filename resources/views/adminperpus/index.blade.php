@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
  <div class="card-header">
    <h6 class="font-weight-bold text-primary">Daftar Wisuda - Administrasi</h6>
    <div class="mb-3">
    <a href="{{ route('wisuda.exportPdf') }}" class="btn btn-danger">
        Export PDF
    </a>
</div>
  </div>
  <div class="card-body">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Foto</th>
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
                                    <td>        
            <a href="{{ $wisuda->link_bukti_pembayaran }}" 
              target="_blank" 
              class="btn btn-primary btn-sm">
            Lihat Foto
            </a>
            </td>
                        <td>{{ $wisuda->user->username }}</td>
                        <td>{{ $wisuda->user->name }}</td>
                        <td>
                            <div class="mb-2">
                                @if ($wisuda->link_repositori)
                                    <a class="btn btn-primary w-100" href="{{ $wisuda->link_repositori }}" target="_blank">CEK REPO</a>
                                @else
                                    Belum ada data
                                @endif
                            </div>

                            <div class="mb-2">
                                @if ($wisuda->link_publish_jurnal)
                                    <a class="btn btn-primary w-100" href="{{ $wisuda->link_publish_jurnal }}" target="_blank">CEK JURNAL</a>
                                 @else
                                    Belum ada data 
                                @endif
                            </div>
                            <div class="mb-2">
                                @if ($wisuda->link_bukti_skripsi)
                                    <a class="btn btn-primary w-100" href="{{ $wisuda->link_bukti_skripsi }}" target="_blank">CEK BUKTI SKRIPSI</a>
                                 @else
                                    Belum ada data
                                @endif
                            </div>
                            <div class="mb-2">
                                 @if ($wisuda->link_bukti_perpus)
                                <a class="btn btn-primary w-100" href="{{ $wisuda->link_bukti_perpus }}" target="_blank">CEK BUKTI PERPUS</a>
                                @else
                                    Belum ada data
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="mb-2">
                                <strong>Repository:</strong> 
                                @if ($wisuda->validasi_repo == '1')
                                    <span class="badge bg-success">Sudah divalidasi</span>
                                @elseif ($wisuda->validasi_repo == '2')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum divalidasi</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <strong>Jurnal:</strong>
                                @if ($wisuda->validasi_jurnal == '1')
                                    <span class="badge bg-success">Sudah divalidasi</span>
                                @elseif ($wisuda->validasi_jurnal == '2')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum divalidasi</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <strong>Skripsi:</strong>
                                @if ($wisuda->validasi_skripsi == '1')
                                    <span class="badge bg-success">Sudah divalidasi</span>
                                @elseif ($wisuda->validasi_skripsi == '2')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum divalidasi</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <strong>Bebas Perpus:</strong> 
                                @if ($wisuda->validasi_perpus == '1')
                                    <span class="badge bg-success">Sudah divalidasi</span>
                                @elseif ($wisuda->validasi_perpus == '2')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum divalidasi</span>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div class="mb-2">
                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasirepo', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Validasi Repo</button>
                                    </form>
                                    <form method="POST" action="{{ route('adminperpus.wisuda.rejectrepo', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-danger w-100" type="submit">Reject Repo</button>
                                    </form>
                            </div>

                            <div class="mb-2">
                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasijurnal', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Validasi Jurnal</button>
                                    </form>
                                    <form method="POST" action="{{ route('adminperpus.wisuda.rejectjurnal', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-danger w-100" type="submit">Reject Jurnal</button>
                                    </form>
                            </div>

                            <div class="mb-2">

                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasiskripsi', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit">Validasi Skripsi</button>
                                    </form>
                                    <form method="POST" action="{{ route('adminperpus.wisuda.rejectskripsi', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-danger w-100" type="submit">Reject Skripsi</button>
                                    </form>
                            </div>

                            <div class="mb-2">
                                    <form method="POST" action="{{ route('adminperpus.wisuda.validasiperpus', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-primary w-100" type="submit" >Validasi Bebas Perpus</button>
                                    </form>
                                    <form method="POST" action="{{ route('adminperpus.wisuda.rejectperpus', $wisuda->id) }}">
                                        @csrf
                                        <button class="btn btn-danger w-100" type="submit">Reject Perpus</button>
                                    </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
