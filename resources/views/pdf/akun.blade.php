<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Akun</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Daftar Akun Generated</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($akunData as $akun)
                <tr>
                    <td>{{ $akun['nama'] }}</td>
                    <td>{{ $akun['username'] }}</td>
                    <td>{{ $akun['password'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>    
</body>
</html>
