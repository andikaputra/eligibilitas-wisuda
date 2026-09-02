<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Cetak Semua Kartu Yudisium
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
        }


        /* =====================================================
           HALAMAN A4
        ===================================================== */

        .page {

            width: 100%;
            height: 281mm;

            display: grid;

            grid-template-columns: 1fr 1fr;
            grid-template-rows: repeat(4, 1fr);

            column-gap: 4mm;
            row-gap: 4mm;

            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }


        /* =====================================================
           KARTU
        ===================================================== */

        .card {

            background: #ffffff;

            border: 1px solid #999;

            border-radius: 5px;

            overflow: hidden;

            display: flex;
            flex-direction: column;

            min-height: 0;
        }


        /* =====================================================
           HEADER KARTU
        ===================================================== */

        .header {

            height: 25mm;

            padding: 5mm 5mm;

            background: #00ABFF;

            color: white;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }


        .header-left h1 {

            margin: 0;

            font-size: 16px;

            line-height: 1.1;
        }


        .header-left p {

            margin: 3px 0 0;

            font-size: 9px;

            font-weight: bold;
        }


        /* =====================================================
           NOMOR URUT
        ===================================================== */

        .nomor-box {

            text-align: center;

            background: white;

            color: #00ABFF;

            padding: 4px 8px;

            border-radius: 5px;

            min-width: 25mm;
        }


        .nomor-box small {

            display: block;

            font-size: 6px;

            font-weight: bold;

            margin-bottom: 2px;
        }


        .nomor-box strong {

            display: block;

            font-size: 18px;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .content {

            padding: 4mm;

            flex: 1;
        }


        /* =====================================================
           JUDUL IDENTITAS
        ===================================================== */

        .identity-title {

            font-size: 9px;

            font-weight: bold;

            color: #00ABFF;

            margin-bottom: 3mm;

            border-bottom: 1px solid #00ABFF;

            padding-bottom: 1.5mm;
        }


        /* =====================================================
           IDENTITAS
        ===================================================== */

        .identity {

            display: grid;

            grid-template-columns: 20mm 1fr;

            row-gap: 2mm;
        }


        .label {

            font-size: 7px;

            font-weight: bold;

            color: #555;
        }


        .value {

            font-size: 7px;

            color: #222;

            overflow-wrap: anywhere;
        }


        /* =====================================================
           STATUS
        ===================================================== */

        .status {

            margin-top: 4mm;

            padding: 3mm;

            text-align: center;

            border: 1px solid #00ABFF;

            border-radius: 4px;
        }


        .status-title {

            font-size: 6px;

            color: #666;

            margin-bottom: 1mm;
        }


        .status-text {

            font-size: 10px;

            font-weight: bold;

            color: #00ABFF;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {

            height: 7mm;

            padding: 2mm;

            background: #f8f9fa;

            text-align: center;

            font-size: 6px;

            color: #777;
        }


        /* =====================================================
           PRINT
        ===================================================== */

        @media print {

            body {

                padding: 0;

                background: white;
            }

            .page {

                width: 100%;

                height: 281mm;
            }

            .card {

                box-shadow: none;

                break-inside: avoid;
            }

        }


        /* =====================================================
           TAMPILAN SCREEN
        ===================================================== */

        @media screen {

            body {

                background: #eee;

                padding: 15px;
            }

            .page {

                width: 210mm;

                height: 281mm;

                margin: 0 auto 20px;

                padding: 0;

                background: white;

                box-shadow: 0 0 10px rgba(0,0,0,0.2);
            }

        }

    </style>

</head>


<body>


{{-- =========================================================
     8 KARTU PER HALAMAN
========================================================= --}}

@foreach($yudisiums->chunk(8) as $chunk)

    <div class="page">

        @foreach($chunk as $yudisium)

            <div class="card">


                {{-- HEADER --}}

                <div class="header">

                    <div class="header-left">

                        <h1>
                            KARTU PESERTA
                        </h1>

                        <p>
                            YUDISIUM
                        </p>

                    </div>


                    {{-- NOMOR URUT --}}

                    <div class="nomor-box">

                        <small>
                            NOMOR URUT
                        </small>

                        <strong>
                            {{ $yudisium->no_urut ?? '-' }}
                        </strong>

                    </div>

                </div>


                {{-- CONTENT --}}

                <div class="content">


                    {{-- IDENTITAS --}}

                    <div class="identity-title">

                        Identitas Peserta

                    </div>


                    <div class="identity">


                        {{-- NAMA --}}

                        <div class="label">
                            Nama
                        </div>

                        <div class="value">
                            {{ $yudisium->user->name ?? '-' }}
                        </div>


                        {{-- NIM --}}

                        <div class="label">
                            NIM
                        </div>

                        <div class="value">
                            {{ $yudisium->user->username ?? '-' }}
                        </div>


                        {{-- PRODI --}}

                        <div class="label">
                            Prodi
                        </div>

                        <div class="value">
                            {{ $yudisium->user->prodi ?? '-' }}
                        </div>


                    </div>


                    {{-- STATUS --}}

                    <div class="status">

                        <div class="status-title">

                            Status Peserta

                        </div>

                        <div class="status-text">

                            SIAP YUDISIUM

                        </div>

                    </div>


                </div>


                {{-- FOOTER --}}

                <div class="footer">

                    Kartu Peserta Yudisium

                </div>


            </div>

        @endforeach

    </div>

@endforeach


</body>

</html>