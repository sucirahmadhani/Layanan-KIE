@extends('layout.admin')

@section('title', 'Topik')

@section('content')
<div class="p-6 bg-white shadow-md rounded-md">
    <div class="items-center mb-4">
        @include('component.tambahtopik')
    </div>    

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-400">
                <tr>
                    <th class="px-5 py-3 text-left text-sm font-bold text-gray-900 tracking-wide">Judul</th>
                    <th class="px-5 py-3 text-center text-sm font-bold text-gray-900 tracking-wide">Tahun</th>
                    <th class="px-5 py-3 text-center text-sm font-bold text-gray-900 tracking-wide">Soal</th>
                    <th class="px-5 py-3 text-center text-sm font-bold text-gray-900 tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody>   
                @foreach ($topiks as $topik)
                <tr class="border-t">
                    <td class="px-5 py-3">{{ $topik->judul }}</td>
                    <td class="px-5 py-3 text-center">{{ $topik->tahun }}</td>
                    <td class="px-5 py-3 text-center">
                        <a href="{{ route('soal.show', $topik->id) }}" class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600 items-center">
                            LIHAT
                        </a>
                    </td>
                    <td class="px-5 py-3 w-auto flex justify-center items-center space-x-2">
                        <button onclick="openEditModal('{{ $topik->id }}', '{{ $topik->judul }}', '{{ $topik->tahun }}')" 
                            class="text-blue-500 hover:text-blue-700 flex items-center">
                            <i class="fas fa-pen-to-square"></i> 
                        </button>
                        @include('component.edittopik')

                        <form action="{{ route('topik.destroy', $topik->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                                <i class="fas fa-trash"></i> 
                            </button>
                        </form>
                    </td>                                         
                </tr>
                @endforeach
            </tbody>
        </table>
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
