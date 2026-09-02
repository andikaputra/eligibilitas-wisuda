<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Kartu Peserta Yudisium</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
            border: 1px solid #ddd;
        }

        .header {
            padding: 25px 30px;
            background: #00ABFF;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            margin: 0;
            font-size: 28px;
        }

        .header-left p {
            margin: 6px 0 0;
            font-size: 16px;
        }

        .nomor-box {
            text-align: center;
            background: white;
            color: #00ABFF;
            padding: 12px 20px;
            border-radius: 8px;
            min-width: 120px;
        }

        .nomor-box small {
            display: block;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .nomor-box strong {
            display: block;
            font-size: 28px;
        }

        .content {
            padding: 30px;
        }

        .identity-title {
            font-size: 18px;
            font-weight: bold;
            color: #00ABFF;
            margin-bottom: 20px;
            border-bottom: 2px solid #00ABFF;
            padding-bottom: 8px;
        }

        .identity {
            display: grid;
            grid-template-columns: 180px 1fr;
            row-gap: 12px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .value {
            color: #222;
        }

        .status {
            margin-top: 30px;
            padding: 18px;
            text-align: center;
            border: 2px solid #00ABFF;
            border-radius: 8px;
        }

        .status-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .status-text {
            font-size: 22px;
            font-weight: bold;
            color: #00ABFF;
        }

        .footer {
            padding: 15px 30px;
            background: #f8f9fa;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        @media print {

            body {
                padding: 0;
                background: white;
            }

            .card {
                box-shadow: none;
                border: 1px solid #000;
            }

        }

    </style>

</head>


<body>

<div class="container">

    <div class="card">

        {{-- HEADER --}}

        <div class="header">

            <div class="header-left">

                <h1>KARTU PESERTA</h1>

                <p>YUDISIUM</p>

            </div>


            <div class="nomor-box">

                <small>NOMOR URUT</small>

                <strong>
                    {{ $yudisium?->no_urut ?? '-' }}
                </strong>

            </div>

        </div>


        {{-- IDENTITAS --}}

        <div class="content">

            <div class="identity-title">
                Identitas Peserta
            </div>


            <div class="identity">

                <div class="label">
                    Nama Lengkap
                </div>

                <div class="value">
                    {{ $user->name ?? '-' }}
                </div>


                <div class="label">
                    NIM
                </div>

                <div class="value">
                    {{ $user->username ?? '-' }}
                </div>


                <div class="label">
                    Program Studi
                </div>

                <div class="value">
                    {{ $user->prodi ?? '-' }}
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

</div>

</body>

</html>