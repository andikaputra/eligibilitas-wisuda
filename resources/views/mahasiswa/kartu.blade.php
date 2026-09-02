<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kartu Peserta Yudisium & Wisuda</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f1f5f9;
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border: 1px solid #e2e8f0;
        }

        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 28px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            margin: 0;
            font-size: 26px;
        }

        .header-left p {
            margin: 8px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .nomor-box {
            background: white;
            color: #1d4ed8;
            min-width: 110px;
            padding: 14px 18px;
            border-radius: 12px;
            text-align: center;
        }

        .nomor-box small {
            display: block;
            font-size: 11px;
            font-weight: bold;
            color: #64748b;
            margin-bottom: 4px;
        }

        .nomor-box strong {
            display: block;
            font-size: 32px;
            line-height: 1;
        }

        .content {
            padding: 30px 32px;
        }

        .identity-title {
            font-size: 15px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .identity {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 10px 20px;
        }

        .label {
            font-weight: bold;
            color: #64748b;
        }

        .value {
            color: #0f172a;
        }

        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 28px 0;
        }

        .status {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #1e40af;
        }

        .footer {
            padding: 18px 32px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }

        .print-button {
            margin-top: 20px;
            text-align: center;
        }

        .print-button button {
            border: none;
            background: #2563eb;
            color: white;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .print-button button:hover {
            background: #1d4ed8;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ccc;
            }

            .print-button {
                display: none;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .header {
                padding: 22px;
                gap: 15px;
            }

            .header-left h1 {
                font-size: 20px;
            }

            .nomor-box {
                min-width: 85px;
            }

            .nomor-box strong {
                font-size: 25px;
            }

            .content {
                padding: 22px;
            }

            .identity {
                grid-template-columns: 1fr;
                gap: 5px;
                margin-bottom: 14px;
            }

            .value {
                margin-bottom: 10px;
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
                <p>Yudisium & Wisuda</p>
            </div>

            <div class="nomor-box">
                <small>NOMOR URUT</small>

                <strong>
                    {{ $wisuda?->no_urut ?? '-' }}
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
                    Username / NIM
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


            <div class="divider"></div>


            <div class="status">
                <strong>Kartu Peserta Yudisium & Wisuda</strong><br>
                Harap menyimpan dan membawa kartu ini pada saat pelaksanaan
                Yudisium dan Wisuda.
            </div>

        </div>


        {{-- FOOTER --}}
        <div class="footer">
            Universitas Markandeya
        </div>

    </div>


    {{-- BUTTON CETAK --}}
    <div class="print-button">
        <button onclick="window.print()">
            🖨 Cetak Kartu
        </button>
    </div>

</div>

</body>
</html>