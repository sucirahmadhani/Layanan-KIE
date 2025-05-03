@extends('layout.admin')

@section('title', 'Profil')

@section('content')
<div class="min-h-screen bg-white p-3">
    <div class="max-w-3xl mx-auto bg-gray-100 p-5 rounded shadow">

        <div class="flex items-center mb-6 space-x-4 text-sm font-semibold">
            <button onclick="showTab('edit')" id="edit-tab" class="text-green-600 hover:underline">Edit Profil</button>
            <span>|</span>
            <button onclick="showTab('password')" id="password-tab" class="text-blue-600 hover:underline">Ganti Password</button>
        </div>

        {{-- Edit Profil --}}
        <form id="edit-form" action="#" method="POST" class="space-y-3">
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

            <div class="text-right pt-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md">
                    Simpan
                </button>
            </div>
        </form>

        {{-- Ganti Password --}}
        <form id="password-form" action="" method="POST" class="space-y-3 hidden">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Password Lama</label>
                <input type="password" name="old_password"
                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Password Baru</label>
                <input type="password" name="new_password"
                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                    class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="text-right pt-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
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
</script>

@endsection
