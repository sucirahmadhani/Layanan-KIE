<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Registrasi Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
  </head>

  <body class="bg-white min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white py-4 px-4">
      <div class="max-w-6xl mx-auto flex items-center justify-between">
        <a href="/" class="flex items-center space-x-3">
          <img src="/img/Group12.png" alt="Logo" class="h-16">
        </a>
        <img src="/img/kataBPOM.svg" alt="BPOM" class="h-12 sm:h-16">
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4 py-8">
      <div class="w-full max-w-md">
        <form class="card shadow-lg" action="/register" method="POST" autocomplete="off" novalidate>
          @csrf
          <div class="card-body bg-blue-900 p-6 rounded-xl">
            <h2 class="text-white text-2xl font-bold text-center mb-6">Registrasi Akun</h2>

            <div class="mb-4">
              <label class="form-label text-white">Nama</label>
              <input type="text" name="nama" class="form-control" placeholder="Masukkan nama anda" required>
            </div>

            <div class="mb-4">
              <label class="form-label text-white">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Masukkan username anda" required>
            </div>

            <div class="mb-4">
              <label class="form-label text-white">Password</label>
              <div class="relative">
                <input type="password" name="password" id="password" class="form-control pr-10" placeholder="Masukkan password anda" required>
                <i class="fas fa-eye absolute top-3 right-3 cursor-pointer hover:text-black" id="togglePassword"></i>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label text-white">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Masukkan email anda" required>
            </div>

            <div class="mb-6">
              <label class="form-label text-white">No WhatsApp</label>
              <input type="text" name="phone_number" class="form-control" placeholder="Contoh: 6281234567898" required>
            </div>

            <div class="mb-4 text-center">
              <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-2 rounded-md transition duration-200">
                Daftar
              </button>
            </div>

            <p class="text-center text-white text-sm mt-4">
              Sudah punya akun?
              <a href="/login" class="text-green-400 hover:text-green-300 font-semibold">Masuk di sini</a>
            </p>
          </div>
        </form>
      </div>
    </main>

    <!-- Notifikasi -->
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

    <!-- Script -->
    <script>
      const togglePassword = document.getElementById("togglePassword");
      const password = document.getElementById("password");

      togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
      });

      setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
      }, 3000);
    </script>
  </body>
</html>
