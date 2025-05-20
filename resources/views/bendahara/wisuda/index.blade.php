@extends('layouts.app')

@section('content')
<h1>Data Wisuda</h1>

@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Status Bendahara</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $wisuda)
        <tr>
            <td>{{ $wisuda->id }}</td>
            <td>{{ $wisuda->nama }}</td>
            <td>{{ $wisuda->status_bendahara ?? 'Belum divalidasi' }}</td>
            <td>
                @if($wisuda->status_bendahara !== 'valid')
                <form method="POST" action="{{ route('bendahara.wisuda.validasi', $wisuda->id) }}">
                    @csrf
                    <button type="submit">Validasi</button>
                </form>
                @else
                Sudah Valid
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
