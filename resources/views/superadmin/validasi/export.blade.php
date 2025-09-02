<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Wisuda</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Daftar Wisuda - Validasi Pembayaran</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Status Repo</th>
                <th>Status Jurnal</th>
                <th>Status Skripsi</th>
                <th>Status Perpus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $wisuda)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $wisuda->user->username }}</td>
                <td>{{ $wisuda->user->name }}</td>
                <td>{{ $wisuda->user->prodi }}</td>
                <td>
                    @if ($wisuda->validasi_repo == '1') ✅
                    @elseif ($wisuda->validasi_repo == '2') ❌
                    @else ⏳
                    @endif
                </td>
                <td>
                    @if ($wisuda->validasi_jurnal == '1') ✅
                    @elseif ($wisuda->validasi_jurnal == '2') ❌
                    @else ⏳
                    @endif
                </td>
                <td>
                    @if ($wisuda->validasi_skripsi == '1') ✅
                    @elseif ($wisuda->validasi_skripsi == '2') ❌
                    @else ⏳
                    @endif
                </td>
                <td>
                    @if ($wisuda->validasi_perpus == '1') ✅
                    @elseif ($wisuda->validasi_perpus == '2') ❌
                    @else ⏳
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
