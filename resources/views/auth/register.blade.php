<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
	<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    @vite('resources/css/app.css')
	<title>Layanan KIE - BBPOM di Padang</title>
    <link href="./dist/css/tabler.min.css?1738096682" rel="stylesheet"/>
	<link href="./dist/css/tabler-flags.min.css?1738096682" rel="stylesheet"/>
	<link href="./dist/css/tabler-socials.min.css?1738096682" rel="stylesheet"/>
	<link href="./dist/css/tabler-payments.min.css?1738096682" rel="stylesheet"/>
	<link href="./dist/css/tabler-vendors.min.css?1738096682" rel="stylesheet"/>
	<link href="./dist/css/tabler-marketing.min.css?1738096682" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1738096682" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/js/tabler.min.js"></script>
    <script src="./dist/js/demo-theme.min.js?1738096682"></script>
	<style>
		@import url('https://rsms.me/inter/inter.css');
	</style>
</head>

<body class="d-flex flex-column bg-white">
    <div class="page">
        <header class="navbar navbar-expand-md d-print-none shadow-none mt-5 " >
            <div class="container-xl">
                <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="/"><img src="/img/Group12.png" alt=""></a>
                </div>
            </div>
        </header>
        <div class="container container-tight py-4 ">
            <form class="card card-md" action="/register" method="POST" autocomplete="off" novalidate>
                @csrf
                <div class="card-body bg-blue-900">
                    <h2 class="h2 text-center mb-4 text-white">Registrasi Akun</h2>
                    <div class="mb-3">
                        <label class="form-label text-white">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">
                          Password
                        </label>
                        <div class="mt-2 mb-3 relative">
                            <input
                              type="password"
                              name="password"
                              id="password"
                              placeholder="Masukkan password anda"
                              autocomplete="current-password"
                              required
                              class="form-control" autocomplete="off">
                              <i
                              class="fas fa-eye absolute top-3 right-3 text-gray-500 cursor-pointer hover:text-blue-500"
                              id="togglePassword">
                            </i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email anda">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">No WhatsApp</label>
                        <input type="text" name="phone_number" class="form-control" placeholder="Ex: 6281234567898">
                    </div>
                    <div class="mb-2">
                        <div class="flex">
                            <button type="submit" class="flex w-1/2 mx-auto justify-center rounded-md mt-6 bg-green-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Daftar</button>
                        </div>
                    </div>
                    <p class="mt-3 mb-2 text-center text-sm/6 text-white">
                        Sudah punya akun?
                        <a href="/login" class="font-semibold text-green-500 hover:text-green-400">Silakan masuk di sini</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
    @if (session('success'))
    <div id="toast-success" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="flex items-center w-full max-w-xs p-4 text-green-800 bg-green-100 rounded-lg shadow">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if ($errors->any())
    <div id="toast-error" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="flex items-center w-full max-w-xs p-4 text-red-800 bg-red-100 rounded-lg shadow">
            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-sm font-medium">{{ $errors->first() }}</span>
        </div>
    </div>
@endif

@include('auth.footer')
<script src="./dist/js/tabler.min.js?1738096682" defer></script>
<script src="./dist/js/demo.min.js?1738096682" defer></script>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
    });

    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
    }, 2000);
</script>
</body>
</html>
