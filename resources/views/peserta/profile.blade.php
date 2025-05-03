@extends('peserta.peserta')

@section('title', 'Akun')

@section('content')
<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-blue-900 ml-5">Akun</h1>
    </div>
</header>

<div class="min-h-screen bg-gray-100 p-3">
    <div class="max-w-3xl mx-auto bg-white p-5 rounded shadow">

        {{-- Edit Profil --}}
        <form id="edit-form" action="{{ route('peserta.updateProfile') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $pengguna->nama ?? '') }}"
                    class="w-full px-2 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $pengguna->username ?? '') }}"
                    class="w-full px-2 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="text" name="email" value="{{ old('email', $pengguna->email ?? '') }}"
                    class="w-full px-2 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Password Baru</label>
                <input type="password" name="new_password" class="w-full px-2 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="text-right pt-4">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded">
                    Simpan
                </button>
            </div>
        </form>
        @if (session('success'))
            <p class="text-green-600 text-center mt-4">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <p class="text-red-600 text-center mt-4">{{ $errors->first() }}</p>
        @endif
    </div>
</div>
@endsection


