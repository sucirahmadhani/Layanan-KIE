<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <title>Layanan KIE - BBPOM di Padang</title>

  @vite('resources/css/app.css')

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

  <style>
    @import url('https://rsms.me/inter/inter.css');
  </style>
</head>
<body class="bg-white min-h-screen flex flex-col">
  <div class="flex flex-col">
    <!-- Header -->
    <header class="navbar navbar-expand-md d-print-none shadow-none py-6 px-4">
        <div class="container-xl flex justify-between items-center max-w-screen-xl mx-auto">
        <a href="/" class="navbar-brand flex items-center space-x-3">
            <img src="/img/Group12.png" alt="Logo" class="h-25">
        </a>
        <img src="/img/kataBPOM.svg" alt="BPOM" class="h-20">
        </div>
    </header>

    <!-- Main content -->
    <main class="flex-grow flex flex-col lg:flex-row items-center justify-center px-4 container mx-auto">
      <!-- Left Text -->
      <div class="hidden lg:block w-full lg:w-1/2 px-4">
        <div class="text-left max-w-xl mx-auto">
          <h1 class="text-blue-900 font-bold text-4xl mb-3">Selamat Datang</h1>
          <h2 class="text-blue-900 font-bold text-2xl mb-2">di "POJOK KIE POM PADANG"</h2>
          <h2 class="text-blue-900 font-bold text-2xl mb-2">Layanan Komunikasi Informasi dan Edukasi (KIE)</h2>
          <h3 class="text-blue-900 font-bold text-xl mb-3">BALAI BESAR PENGAWASAN OBAT DAN MAKANAN (POM) DI PADANG</h3>
          <p class="text-black font-bold text-lg">Dapatkan Edukasi yang Tepercaya untuk Cerdas Memilih Obat dan Makanan yang Aman dan Bermutu!</p>
        </div>
      </div>

      <!-- Right Form -->
      <div class="w-full lg:w-1/2 px-4 mt-8 lg:mt-0">
        <div class="max-w-md mx-auto">
          <div class="card card-md">
            <div class="card-body bg-blue-900 rounded-xl shadow-lg">
              <h2 class="h2 text-center mb-4 text-white">Masuk ke akun anda</h2>
              <form action="/login" method="POST" autocomplete="off" novalidate>
                @csrf
                <div class="mb-4">
                  <label class="form-label text-white">Username</label>
                  <input type="text" name="username" class="form-control" required />
                </div>
                <div class="mb-4">
                  <label class="form-label text-white">Password</label>
                  <div class="relative">
                    <input type="password" name="password" id="password" class="form-control" required />
                    <i class="fas fa-eye absolute right-3 top-3 cursor-pointer hover:text-green-300" id="togglePassword"></i>
                  </div>
                  <div class="mt-2 text-right">
                    <a href="/forgot-password" class="text-sm font-semibold text-green-500 hover:text-green-400">Lupa Password?</a>
                  </div>
                </div>
                <div class="mb-4 text-center">
                  <button type="submit" class="w-1/2 bg-green-600 hover:bg-green-500 text-white font-semibold py-2 rounded-md">Masuk</button>
                </div>
              </form>
              <p class="text-center text-sm text-white mt-4">
                Tidak punya akun? <a href="/register" class="font-semibold text-green-500 hover:text-green-400">Silakan daftar di sini</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Toast -->
  @if (session('success'))
    <div id="toast-success" class="fixed top-5 inset-x-0 flex justify-center z-50">
      <div class="flex items-center w-fit px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow">
        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-width="2" d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if ($errors->any())
    <div id="toast-error" class="fixed top-5 inset-x-0 flex justify-center z-50">
      <div class="flex items-center w-fit px-4 py-2 bg-red-100 text-red-800 rounded-lg shadow">
        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-width="2" d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="text-sm font-medium">{{ $errors->first() }}</span>
      </div>
    </div>
  @endif

  @include('auth.footer')

  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/js/tabler.min.js"></script>
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
