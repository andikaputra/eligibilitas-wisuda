@extends('layouts.app')

@section('title', 'SKPI & Ijazah')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle mr-1"></i>
        {{ session('success') }}
    </div>
@endif

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            SKPI & Ijazah
        </h6>
    </div>

    <div class="card-body">

        <div class="alert alert-info">
            Dokumen SKPI dan Ijazah Anda dapat dilihat setelah
            dokumen diunggah oleh admin.
        </div>

        <div class="row">

       {{-- SKPI --}}
<div class="col-md-8 mx-auto">
    <div class="card h-100" style="min-height: 600px;">

        <div class="card-body">

            <div class="text-center">

                <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>

                <h5 class="font-weight-bold">
                    SKPI
                </h5>

                <p class="text-muted">
                    Surat Keterangan Pendamping Ijazah
                </p>

            </div>

            <hr>

            <form
                action="{{ route('mahasiswa.dokumen.store') }}"
                method="POST"
            >

                @csrf

                <div class="form-group">

                    <div class="text-center py-3">

    <p class="text-muted mb-4">
        Silakan lengkapi data SKPI melalui formulir
        yang telah disediakan oleh universitas.
    </p>

    <a href="https://forms.gle/dKyYXctUrtJikgnc8"
       target="_blank"
       rel="noopener noreferrer"
       class="btn btn-primary">

        <i class="fas fa-edit mr-1"></i>
        Isi Form SKPI

    </a>

</div>

            </form>

        </div>

    </div>
</div>

           
        </div>

    </div>

</div>

@endsection