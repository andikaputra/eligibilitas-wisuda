<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Kartu Wisuda</title>

    <style>
        @page {
            size: A4;
            margin: 0;
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

        .page {
            width: 210mm;
            min-height: 297mm;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
        }

        .kartu {
            width: 180mm;
            border: 2px solid #00ABFF;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
        }

        .logo {
            width: 80px;
            margin-bottom: 10px;
        }

        .universitas {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .judul {
            font-size: 26px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .data {
            text-align: left;
            width: 80%;
            margin: 0 auto;
        }

        .row {
            display: flex;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .label {
            width: 130px;
            font-weight: bold;
        }

        .titik {
            width: 20px;
        }

        .value {
            flex: 1;
        }

        .nomor {
            margin-top: 30px;
            padding: 15px;
            border: 2px solid #00ABFF;
            border-radius: 10px;
        }

        .nomor-label {
            font-size: 15px;
            font-weight: bold;
        }

        .nomor-value {
            font-size: 40px;
            font-weight: bold;
            margin-top: 5px;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
        }

        .no-print {
            text-align: center;
            margin: 20px;
        }

        .btn-print {
            padding: 10px 20px;
            border: none;
            background: #00ABFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none;
            }

            .page {
                min-height: 297mm;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button
            class="btn-print"
            onclick="window.print()">
            🖨 Cetak Kartu
        </button>
    </div>

    <div class="page">

        <div class="kartu">

            {{-- LOGO --}}
            {{-- Nanti kita masukkan logo Universitas di sini --}}

            <div class="universitas">
                UNIVERSITAS MARKANDEYA
            </div>

            <div class="judul">
                KARTU PESERTA WISUDA
            </div>

            <div class="data">

                <div class="row">
                    <div class="label">Nama</div>
                    <div class="titik">:</div>
                    <div class="value">
                        {{ $wisuda->user->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="label">NIM</div>
                    <div class="titik">:</div>
                    <div class="value">
                        {{ $wisuda->user->username ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="label">Program Studi</div>
                    <div class="titik">:</div>
                    <div class="value">
                        {{ $wisuda->user->prodi ?? '-' }}
                    </div>
                </div>

            </div>

            <div class="nomor">

                <div class="nomor-label">
                    NOMOR URUT WISUDA
                </div>

                <div class="nomor-value">
                    {{ $wisuda->no_urut ?? '-' }}
                </div>

            </div>

            <div class="footer">
                Kartu ini merupakan kartu peserta Wisuda
                Universitas Markandeya.
            </div>

        </div>

    </div>

</body>
</html>