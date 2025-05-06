@extends('layout.admin')

@section('back', route('topik.index'))

@section('title', 'Soal')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold text-blue-900 mb-2">{{ $topik->judul }}</h1>
        <div class="flex justify-end mb-4">
            <a href="{{ route('soal.create', ['topik' => $topik->id]) }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                Tambah Soal
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-400">
                    <tr>
                        <th class="px-4 py-3 tracking-wide w-2/3">Pertanyaan</th>
                        <th class="px-4 py-3 tracking-wide text-center w-1/6">Tampilkan</th>
                        <th class="px-4 py-3 tracking-wide text-center w-1/6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soals as $soal)
                    <tr class="border-t">
                        <td class="px-4 py-3 border">
                            <div class="font-medium">{{ $soal->pertanyaan }}</div>
                            <ul class="mt-2 text-sm list-disc list-inside">
                                <li class="text-green-600">
                                    {{ $soal->opsi_benar }}
                                </li>
                                @foreach ($soal->opsi as $index => $opsi)
                                    <li class="{{ $index == $soal->opsi_benar ? 'text-green-600 font-semibold' : '' }}">
                                        {{ $opsi }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-3 border text-center">
                            @if ($soal->tampilkan)
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Ya</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">Tidak</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-center align-middle">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ route('soal.edit', $soal->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('soal.destroy', $soal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    @if ($soals->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">Belum ada soal.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
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

<script>
    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
    }, 2000);
</script>
@endsection
