<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Data Ijazah</title>
    <style>
        @page { margin: 16px 18px 28px; }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 7px;
        }

        h1 {
            margin: 0;
            font-size: 15px;
            text-align: center;
        }

        .subtitle {
            margin: 4px 0 12px;
            color: #4b5563;
            font-size: 8px;
            text-align: center;
        }

        .summary {
            margin-bottom: 10px;
            font-size: 7px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #9ca3af;
            padding: 4px 3px;
            overflow-wrap: break-word;
            vertical-align: top;
        }

        thead th {
            background: #1d4ed8;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .group-header {
            background: #1e40af;
        }

        .center {
            text-align: center;
            vertical-align: middle;
        }

        .status-valid {
            color: #047857;
            font-weight: bold;
        }

        .status-rejected {
            color: #b91c1c;
            font-weight: bold;
        }

        .status-pending {
            color: #6b7280;
        }

        .footer {
            position: fixed;
            bottom: -17px;
            left: 0;
            right: 0;
            color: #6b7280;
            font-size: 7px;
            text-align: right;
        }
    </style>
</head>
<body>
    @php
        $statusFields = ['nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'nim', 'prodi'];
        $statusLabels = [
            1 => ['class' => 'status-valid', 'label' => 'Valid'],
            2 => ['class' => 'status-rejected', 'label' => 'Perlu diperbaiki'],
        ];
    @endphp

    <h1>DAFTAR DATA IJAZAH MAHASISWA</h1>
    <div class="subtitle">Dicetak pada {{ now()->format('d-m-Y H:i') }}</div>
    <div class="summary">Jumlah data: {{ $ijazahs->count() }} mahasiswa</div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 2.5%;">No</th>
                <th rowspan="2" style="width: 7%;">NIM</th>
                <th rowspan="2" style="width: 10%;">Nama Mahasiswa</th>
                <th rowspan="2" style="width: 8%;">NIK</th>
                <th rowspan="2" style="width: 7%;">Tempat Lahir</th>
                <th rowspan="2" style="width: 6%;">Tgl Lahir</th>
                <th rowspan="2" style="width: 10%;">Prodi</th>
                <th colspan="6" class="group-header">Status Validasi</th>
            </tr>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>Tempat</th>
                <th>Tgl</th>
                <th>NIM</th>
                <th>Prodi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ijazahs as $ijazah)
                @php
                    $tanggalLahir = $ijazah->tanggal_lahir;
                    if ($tanggalLahir instanceof \DateTimeInterface) {
                        $tanggalLahir = $tanggalLahir->format('d-m-Y');
                    }
                @endphp
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $ijazah->user->username ?? $ijazah->nim }}</td>
                    <td>{{ $ijazah->user->name ?? '-' }}</td>
                    <td>{{ $ijazah->nik }}</td>
                    <td>{{ $ijazah->tempat_lahir }}</td>
                    <td class="center">{{ $tanggalLahir ?: '-' }}</td>
                    <td>{{ $ijazah->prodi }}</td>
                    @foreach ($statusFields as $field)
                        @php($status = $ijazah->{'validasi_' . $field})
                        @php($statusInfo = $statusLabels[$status] ?? ['class' => 'status-pending', 'label' => 'Menunggu'])
                        <td class="center {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="center">Belum ada mahasiswa yang mengirim data Ijazah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Daftar Data Ijazah Mahasiswa</div>
</body>
</html>
