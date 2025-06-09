<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @vite('resources/css/app.css')
  <title>@yield('title', 'Layanan KIE - BBPOM di Padang')</title>

  <!-- Tailwind & Flowbite -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />

  <style>
    @import url('https://rsms.me/inter/inter.css');
  </style>
</head>
<body>

<div class="min-h-full">
  <!-- Navbar -->
  <nav class="bg-blue-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-20 items-center justify-between">
        <!-- Logo & Links -->
        <div class="flex items-center">
          <a href="/beranda">
            <img class="w-24 m-4" src="/img/logo.png" alt="BPOM Logo" />
          </a>
          <div class="hidden md:block ml-6">
            <a href="/beranda" class="rounded-md px-3 py-2 text-sm font-medium {{ Request::is('beranda') ? 'text-white' : 'text-gray-300' }} hover:bg-blue-700 hover:text-white">Beranda</a>
          </div>
        </div>

        <!-- Profile Dropdown - Mobile & Desktop -->
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="flex items-center text-white focus:outline-none">
            <i class="fas fa-user-circle text-3xl"></i>
          </button>
          <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
            <a href="{{ route('peserta.editProfile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-red-100">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    @yield('content')
  </main>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>
</html>
