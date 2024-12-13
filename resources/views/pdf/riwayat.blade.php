<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Riwayat Pasien</h1>

    <h2>Nama Pasien: {{ $riwayat->pasien->nama ?? 'Tidak diketahui' }}</h2>
    <table>
        <tr>
            <th>NIS</th>
            <td>{{ $riwayat->pasien->nis ?? 'Tidak diketahui' }}</td>
        </tr>
        <tr>
            <th>Keluhan</th>
            <td>{{ $riwayat->keluhan }}</td>
        </tr>
        <tr>
            <th>Tindakan</th>
            <td>{{ $riwayat->tindakan }}</td>
        </tr>
        <tr>
            <th>Status Pasien</th>
            <td>{{ $riwayat->status_pasien }}</td>
        </tr>
        <tr>
            <th>Jenis Obat</th>
            <td>{{ $riwayat->obat->jenis_obat }}</td>
        </tr>
        <tr>
            <th>Obat</th>
            <td>{{ $riwayat->obat->nama_obat }}</td>
        </tr>
        <tr>
            <th>Jumlah Dipakai</th>
            <td>{{ $riwayat->obat->jumlah_dipakai }}</td>
        </tr>
        <tr>
            <th>Anjuran</th>
            <td>{{ $riwayat->obat->anjuran }}</td>
        </tr>
        <tr>
            <th>Petugas</th>
            <td>{{ $riwayat->user->name ?? 'Tidak diketahui' }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $riwayat->created_at->format('d F Y H:i') }}</td>
        </tr>
    </table>

</body>
</html>
