<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Cetak Semua Kartu Wisuda</title>

    <style>

        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
        }

        /* ==============================
           TOMBOL
        ============================== */

        .no-print {
            text-align: center;
            padding: 20px;
        }

        .btn-print {
            padding: 10px 20px;
            border: none;
            background: #00ABFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }


        /* ==============================
           KERTAS A4
        ============================== */

        .page {
            width: 194mm;
            height: 281mm;

            display: grid;

            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(4, 1fr);

            gap: 4mm;

            background: white;

            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }


        /* ==============================
           KARTU
        ============================== */

        .kartu {
            border: 1.5px solid #00ABFF;
            border-radius: 6px;

            padding: 8px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            text-align: center;

            overflow: hidden;
        }


        /* ==============================
           IDENTITAS
        ============================== */

        .universitas {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .judul {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 10px;
        }


        /* ==============================
           DATA MAHASISWA
        ============================== */

        .data {
            text-align: left;
            width: 100%;
        }

        .row {
            display: flex;
            margin-bottom: 4px;
            font-size: 10px;
        }

        .label {
            width: 72px;
            font-weight: bold;
        }

        .titik {
            width: 10px;
        }

        .value {
            flex: 1;
        }


        /* ==============================
           NOMOR URUT
        ============================== */

        .nomor {
            margin-top: 8px;

            padding: 5px;

            border: 1px solid #00ABFF;
            border-radius: 5px;
        }

        .nomor-label {
            font-size: 8px;
            font-weight: bold;
        }

        .nomor-value {
            font-size: 25px;
            font-weight: bold;
            margin-top: 2px;
        }


        /* ==============================
           FOOTER
        ============================== */

        .footer {
            margin-top: 6px;
            font-size: 7px;
        }


        /* ==============================
           PRINT
        ============================== */

        @media print {

            body {
                background: white;
            }

            .no-print {
                display: none;
            }

            .page {
                page-break-after: always;
            }

            .page:last-child {
                page-break-after: auto;
            }

        }

    </style>
</head>


<body>


    {{-- ==============================
         TOMBOL CETAK
    ============================== --}}

    <div class="no-print">

        <button
            class="btn-print"
            onclick="window.print()"
        >
            🖨 Cetak Semua Kartu
        </button>

    </div>


    {{-- ==============================
         DATA PESERTA
    ============================== --}}

    @forelse($wisudas->chunk(8) as $kelompok)

        <div class="page">

            @foreach($kelompok as $wisuda)

                <div class="kartu">

                    {{-- UNIVERSITAS --}}
                    <div class="universitas">
                        UNIVERSITAS MARKANDEYA
                    </div>


                    {{-- JUDUL --}}
                    <div class="judul">
                        KARTU PESERTA WISUDA
                    </div>


                    {{-- DATA --}}
                    <div class="data">

                        {{-- NAMA --}}
                        <div class="row">

                            <div class="label">
                                Nama
                            </div>

                            <div class="titik">
                                :
                            </div>

                            <div class="value">
                                {{ $wisuda->user->name ?? '-' }}
                            </div>

                        </div>


                        {{-- NIM --}}
                        <div class="row">

                            <div class="label">
                                NIM
                            </div>

                            <div class="titik">
                                :
                            </div>

                            <div class="value">
                                {{ $wisuda->user->username ?? '-' }}
                            </div>

                        </div>


                        {{-- PRODI --}}
                        <div class="row">

                            <div class="label">
                                Prodi
                            </div>

                            <div class="titik">
                                :
                            </div>

                            <div class="value">
                                {{ $wisuda->user->prodi ?? '-' }}
                            </div>

                        </div>

                    </div>


                    {{-- NOMOR URUT --}}
                    <div class="nomor">

                        <div class="nomor-label">
                            NOMOR URUT WISUDA
                        </div>

                        <div class="nomor-value">
                            {{ $wisuda->no_urut }}
                        </div>

                    </div>


                    {{-- FOOTER --}}
                    <div class="footer">
                        Universitas Markandeya
                    </div>

                </div>

            @endforeach

        </div>

    @empty

        <div class="page">

            <div class="kartu">

                <h3>
                    Belum ada peserta Wisuda
                </h3>

                <p>
                    Belum terdapat mahasiswa yang memenuhi
                    persyaratan untuk dicetak.
                </p>

            </div>

        </div>

    @endforelse


</body>
</html>