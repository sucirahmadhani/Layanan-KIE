@extends('layout.pendaftar')

@section('title', 'Profil')

@section('content')
<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-blue-900 ml-5">Profil</h1>
    </div>
</header>

<div class="min-h-screen bg-gray-100 p-3">
    <div class="max-w-3xl mx-auto bg-white p-5 rounded shadow">
        <div class="flex items-center mb-6 space-x-4 text-sm font-semibold">
            <button onclick="showTab('edit')" id="edit-tab" class="text-green-600 hover:underline">Edit Profil</button>
            <span>|</span>
            <button onclick="showTab('password')" id="password-tab" class="text-blue-600 hover:underline">Ganti Password</button>
        </div>

        {{-- Edit Profil --}}
        <form id="edit-form" action="{{ route('profil.update') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $pengguna->nama ?? '') }}"
                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $pengguna->username ?? '') }}"
                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $pengguna->email ?? '') }}"
                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">No WhatsApp</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $pengguna->phone_number ?? '') }}"
                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="text-right pt-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md">
                    Simpan
                </button>
            </div>
        </form>

        {{-- Ganti Password --}}
        <form id="password-form" action="{{ route('profil.password') }}" method="POST" class="space-y-3 hidden">
            @csrf
            <div class="relative">
                <label class="block text-sm font-medium mb-1">Password Lama</label>
                <input type="password" name="old_password" id="old_password" class="form-control border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                <i class="fas fa-eye absolute top-10 right-3 cursor-pointer" id="toggleOldPassword"></i>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium mb-1">Password Baru</label>
                <input type="password" name="new_password" id="new_password" class="form-control border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                <i class="fas fa-eye absolute top-10 right-3 cursor-pointer" id="toggleNewPassword"></i>
            </div>

            <div class="text-right pt-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md">
                    Simpan
                </button>
            </div>
        </form>
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
</div>

<script>
    function showTab(tab) {
        const editForm = document.getElementById('edit-form');
        const passwordForm = document.getElementById('password-form');
        const editTab = document.getElementById('edit-tab');
        const passwordTab = document.getElementById('password-tab');

        if (tab === 'edit') {
            editForm.classList.remove('hidden');
            passwordForm.classList.add('hidden');
            editTab.classList.add('text-green-600');
            passwordTab.classList.remove('text-green-600');
        } else {
            editForm.classList.add('hidden');
            passwordForm.classList.remove('hidden');
            passwordTab.classList.add('text-green-600');
            editTab.classList.remove('text-green-600');
        }
    }

    document.getElementById("toggleOldPassword").addEventListener("click", function () {
        const input = document.getElementById("old_password");
        const type = input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);
        if (this.classList.contains("fa-eye")) {
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
        } else {
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
        }
    });

    document.getElementById("toggleNewPassword").addEventListener("click", function () {
        const input = document.getElementById("new_password");
        const type = input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);
        if (this.classList.contains("fa-eye")) {
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
        } else {
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
        }
    });

    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
    }, 2000);
</script>
@endsection
