@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Tambah Mahasiswa</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="username" class="form-label">NIM</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required>
        </div>





        <!-- Dropdown Program Studi -->
        <div class="mb-3">
            <label for="prodi" class="form-label">Program Studi</label>
            <select name="prodi" class="form-control" required>
                <option value="">-- Pilih Program Studi --</option>
                @foreach($prodiList as $prodi)
                    <option value="{{ $prodi }}">{{ $prodi }}</option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
