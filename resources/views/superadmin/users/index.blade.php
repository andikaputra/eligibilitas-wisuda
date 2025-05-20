@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Data Wisuda Mahasiswa</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
  <a href="{{ route('users.create') }}" class="btn btn-secondary">Batal</a>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
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
