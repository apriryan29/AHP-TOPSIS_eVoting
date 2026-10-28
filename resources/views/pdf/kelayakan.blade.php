<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kelayakan Kandidat</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f1f1f1;
        }
    </style>
</head>
<body>

    <h2>LAPORAN HASIL KELAYAKAN KANDIDAT</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kandidat</th>
                <th>NIA</th>
                <th>Asal Komisariat</th>
                <th>Status Kelayakan</th>
            </tr>
        </thead>

        <tbody>
            @foreach($hasil as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['nia'] }}</td>
                    <td>{{ $item['komisariat'] }}</td>
                    <td>
                        {{ $item['status'] == 'layak'
                            ? 'Layak'
                            : 'Tidak Layak' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>