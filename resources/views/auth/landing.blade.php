<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <title>Layanan KIE - BBPOM Padang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/js/tabler.min.js"></script>


</head>
<body class="bg-white">
    <header class="mt-6 ml-20 mb-6">
        <div class="logo">
            <a href="/"><img src="/img/Group12.png" alt=""></a>
        </div>
    </header>

    <main class="container flex-grow flex items-center justify-between px-5">

        <div class="w-1/2 ">
            <p class="text-4xl font-bold text-blue-900">Selamat Datang</p>
            <p class="text-2xl text-blue-900 font-bold ">di Layanan Komunikasi Informasi dan Edukasi</p>
            <p class="text-xl text-blue-900 font-bold ">BALAI BESAR POM DI PADANG</p>
            <p class="mt-4 text-black text-lg">Dapatkan edukasi yang berkualitas untuk menunjang kesehatan keluarga anda!</p>
        </div>

        <div class="w-1/3 mt-0  mb-20 bg-blue-900 p-6 rounded-lg shadow-lg">
            <h2 class="text-white text-xl font-bold mb-4 text-center">MASUK</h2>
            <form class="space-y-2" action="#" method="POST">
                <div>
                  <label for="email" class="block text-sm/6 font-medium text-white">Username</label>
                  <div class="mt-2">
                    <input type="email" name="email" id="username" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6">
                  </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                      <label for="password" class="block text-sm font-medium text-white">Password</label>
                    </div>
                    <div class="mt-2 relative">
                      <input
                        type="password"
                        name="password"
                        id="password"
                        autocomplete="current-password"
                        required
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-blue-500 sm:text-sm">
                      <i
                        class="fas fa-eye absolute top-3 right-3 text-gray-500 cursor-pointer hover:text-blue-500"
                        id="togglePassword"
                      ></i>
                    </div>
                </div>

                <div class="flex">
                  <button type="submit" class="flex w-1/2 mx-auto justify-center rounded-md mt-6 bg-green-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Masuk</button>
                </div>
            </form>
            <p class="mt-4 mb-3 text-center text-sm/6 text-white">
                Tidak punya akun?
                <a href="/login" class="font-semibold text-green-500 hover:text-green-400">Silakan daftar di sini</a>
            </p>
        </div>
    </main>

    @include('auth.footer')

</body>
</html>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
    });
</script>