@extends('layout.admin')

@section('title', 'Topik')

@section('content')
<div class="p-6 bg-white shadow-md rounded-md">
    <div class="items-center mb-4">
        @include('component.tambahtopik')
    </div>    

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-400">
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
                        <a href="#" class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600 items-center">
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
@endsection
