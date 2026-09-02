<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Daftar Wisuda</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            text-align: center;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>DAFTAR PESERTA WISUDA</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Urut Peserta</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
            </tr>
        </thead>

        <tbody>

            @foreach($data as $wisuda)

                <tr>
                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="center">
                        {{ $wisuda->no_urut ?? '-' }}
                    </td>

                    <td>
                        {{ $wisuda->user->username ?? '-' }}
                    </td>

                    <td>
                        {{ $wisuda->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ $wisuda->user->prodi ?? '-' }}
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

</body>
</html>