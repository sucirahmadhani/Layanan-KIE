<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite('resources/css/app.css')
  <title>@yield('title', 'Layanan KIE - BBPOM di Padang')</title>

  <!-- CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
  <style>
    @import url('https://rsms.me/inter/inter.css');
  </style>
</head>

<body>
<div class="min-h-full">
  <nav class="bg-blue-900" x-data="{ openMenu: false, openDropdown: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-20 items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center">
          <a href="/home" class="shrink-0">
            <img class="w-24 m-4" src="/img/logo.png" alt="BPOM Logo">
          </a>
          <!-- Desktop Menu -->
          <div class="hidden md:flex ml-10 space-x-4">
            <a href="/home" class="rounded-md px-3 py-2 text-sm font-medium {{ Request::is('home') ?  'text-white' : 'text-gray-300' }} hover:bg-blue-700 hover:text-white">Beranda</a>
            <a href="/proses" class="rounded-md px-3 py-2 text-sm font-medium {{ Request::is('proses') ? ' text-white' : 'text-gray-300' }} hover:bg-blue-700 hover:text-white">Proses</a>
            <a href="/daftar" class="rounded-md px-3 py-2 text-sm font-medium {{ Request::is('daftar') ? 'text-white' : 'text-gray-300' }} hover:bg-blue-700 hover:text-white">Daftar</a>
            <a href="/riwayat" class="rounded-md px-3 py-2 text-sm font-medium {{ Request::is('riwayat') ?  'text-white' : 'text-gray-300' }} hover:bg-blue-700 hover:text-white">Riwayat</a>
          </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="hidden md:block relative" x-data="{ openDropdown: false }">
          <button @click="openDropdown = !openDropdown" class="text-white text-xl focus:outline-none">
            <i class="fas fa-user-circle"></i>
          </button>
          <div x-show="openDropdown" @click.away="openDropdown = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
            <a href="/profil" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-red-100">Logout</button>
            </form>
          </div>
        </div>

        <!-- Mobile Button -->
        <div class="md:hidden">
          <button @click="openMenu = !openMenu" class="text-white p-2 rounded-md focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path :class="{ 'hidden': openMenu, 'block': !openMenu }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
              <path :class="{ 'block': openMenu, 'hidden': !openMenu }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden" x-show="openMenu" @click.away="openMenu = false">
      <div class="space-y-1 px-4 pt-2 pb-3">
        <a href="/home" class="block rounded-md px-3 py-2 text-base font-medium text-white bg-blue-700">Beranda</a>
        <a href="/proses" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Proses</a>
        <a href="/daftar" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Daftar</a>
        <a href="/riwayat" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Riwayat</a>
        <a href="/profil" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Profil</a>
        <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
          @csrf
          <button type="submit" class="block rounded-md text-base font-medium text-gray-300 hover:bg-blue-700 hover:text-white">Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <main>
    @yield('content')
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
