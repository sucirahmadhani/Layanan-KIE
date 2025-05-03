<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite('resources/css/app.css')
  <title>@yield('title', 'Layanan KIE - BBPOM di Padang')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.0/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.3/dist/datepicker.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
  <style>
    @import url('https://rsms.me/inter/inter.css');
  </style>
</head>
<body class="flex h-screen">

  <!-- Sidebar -->
  <aside class="fixed md:relative inset-y-0 left-0 w-64 bg-blue-900 text-white flex flex-col p-5 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50" id="sidebar">
    <img src="/img/logo.png" alt="BPOM Logo" class="w-24 mx-auto mb-10">
    <nav class="flex-1">
      <ul>
        <li class="nav-item mb-3">
          <a class="nav-link flex items-center gap-2 p-2 rounded hover:bg-blue-700" href="/dashboard">
            <i class="fa-solid fa-home"></i>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item mb-3">
          <a class="nav-link flex items-center gap-2 p-2 rounded hover:bg-blue-700" href="/permintaan">
            <i class="fa-solid fa-list"></i>
            <span class="nav-link-title">Permintaan</span>
          </a>
        </li>
        <li class="nav-item mb-3">
          <a class="nav-link flex items-center gap-2 p-2 rounded hover:bg-blue-700" href="/layanan">
            <i class="fa-solid fa-handshake"></i>
            <span class="nav-link-title">Layanan</span>
          </a>
        </li>
        <li class="nav-item mb-3">
          <a class="nav-link flex items-center gap-2 p-2 rounded hover:bg-blue-700" href="/topik">
            <i class="fa-solid fa-newspaper"></i>
            <span class="nav-link-title">Topik</span>
          </a>
        </li>
        <li class="nav-item mb-3">
          <a class="nav-link flex items-center gap-2 p-2 rounded hover:bg-blue-700" href="/narasumber">
            <i class="fa-solid fa-child"></i>
            <span class="nav-link-title">Narasumber
            </span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>


  <!-- Main Content -->
  <div class="flex-1 flex flex-col pt-16 md:pt-0 transition-all duration-300">
    <header class="flex items-center justify-between bg-white shadow-none p-5 fixed w-full top-0 md:static z-40">
        <div class="flex items-center space-x-4">
            @hasSection('back')
                <a href="@yield('back')" class="text-blue-900">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
            @endif

            <button id="menu-button" class="text-blue-900 focus:outline-none md:hidden">
                <i class="fa-solid fa-bars"></i>
            </button>
            
            <h1 class="text-2xl font-bold text-blue-900 md:text-left flex-1">
                @yield('title', 'Dashboard')
            </h1>
        </div>
        <div class="hidden md:block relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 text-white focus:outline-none">
              <img class="size-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
              <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-red-100">Logout</button>
              </form>
            </div>
        </div>
    </header>

    <main class="flex-1 overflow-auto p-3 md:p-8">
        @yield('content')
    </main>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const menuButton = document.getElementById('menu-button');

    if (menuButton) {
      menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
      });
    }
  </script>

</body>
</html>
