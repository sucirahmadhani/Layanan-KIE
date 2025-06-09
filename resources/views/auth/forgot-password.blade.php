<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lupa Password - Layanan KIE</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

  <div class="w-full max-w-md">
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Lupa Password</h2>

      <form class="space-y-7" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
          <input type="email" name="email" id="email" autocomplete="email" required autofocus
            class="mt-2 block w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 sm:text-sm" />
        </div>

        <button type="submit"
          class="w-full rounded-md bg-blue-700 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
          Kirim Link Reset
        </button>
      </form>

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
    </div>
  </div>
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
