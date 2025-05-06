<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
	<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    @vite('resources/css/app.css')
	<title>Layanan KIE - BBPOM di Padang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
	<style>
		@import url('https://rsms.me/inter/inter.css');
	</style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md">
        <div class="card shadow-md rounded-lg bg-white p-6">
            <h2 class="text-center text-xl font-bold text-gray-800 mb-6">Lupa Password</h2>

            <form class="space-y-3" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        Kirim Link Reset
                    </button>
                </div>
                
            </form>

            @if (session('success'))
                <p class="text-green-600 text-center mt-4">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <p class="text-red-600 text-center mt-4">{{ $errors->first() }}</p>
            @endif
        </div>
    </div>
</body>
</html>
