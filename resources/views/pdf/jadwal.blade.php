<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Jadwal Pasien</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Pasien</th>
                <th>Kamar</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwals as $jadwal)
                <tr>
                    <td>{{ $jadwal->pasien->nama }}</td>
                    <td>{{ $jadwal->kamar }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_masuk)->timezone('Asia/Jakarta')->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_keluar)->timezone('Asia/Jakarta')->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
