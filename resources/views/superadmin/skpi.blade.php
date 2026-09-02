@extends('layouts.app')

@section('title', 'Kelola SKPI')

@section('content')

<div class="container-fluid">

    {{-- Judul --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Kelola SKPI
            </h1>

            <p class="mb-0 text-muted">
                Kelola dan periksa data SKPI mahasiswa.
            </p>
        </div>

    </div>


    {{-- Card SKPI --}}
    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-7">

            <div class="card shadow mb-4"
                 style="border-left: 4px solid #4e73df;">

                <div class="card-body text-center py-5">

                    {{-- Icon --}}
                    <div class="mb-3">

                        <i class="fas fa-file-alt"
                           style="
                               font-size: 55px;
                               color: #4e73df;
                           ">
                        </i>

                    </div>


                    {{-- Judul --}}
                    <h4 class="font-weight-bold text-gray-800 mb-2">
                        SKPI Mahasiswa
                    </h4>


                    {{-- Deskripsi --}}
                    <p class="text-muted mb-4">
                        Silakan periksa data SKPI mahasiswa
                        melalui Google Spreadsheet yang telah
                        disediakan oleh universitas.
                    </p>


                    {{-- Tombol Spreadsheet --}}
                    <a
                        href="https://docs.google.com/spreadsheets/d/16mdAKMLifa3AVJV6_ZVRnzz11o2JtXj7XlFf3-d5Mno/edit?usp=sharing"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-primary"
                        style="
                            padding: 10px 22px;
                            font-weight: 600;
                        "
                    >

                        <i class="fas fa-search mr-2"></i>

                        Cek SKPI

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection