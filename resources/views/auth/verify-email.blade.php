<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <style>
        @import url('https://rsms.me/inter/inter.css');
    </style>
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold tracking-tight text-blue-900 ml-5">Verifikasi</h1>
        </div>
    </header>

    <div class="bg-gray-100 flex justify-center items-center h-auto p-5">
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Verifikasi Email Anda</h5>
            <p class="mb-3 font-normal text-gray-800">
                Silakan cek email Anda untuk menemukan link verifikasi. Jika belum menerima email,
                Anda bisa klik tombol di bawah ini untuk mengirim ulang.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>
        </div>
    </div>

</body>
</html>
