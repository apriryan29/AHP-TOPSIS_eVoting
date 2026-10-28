<!DOCTYPE html>
<html>
<head>
    <title>Hasil Pemilihan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Hasil Pemilihan Formatur</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kandidat</th>
            <th>Asal Komisariat</th>
            <th>Perolehan Suara</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->asal_komisariat }}</td>
                <td>{{ $item->total_suara }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>