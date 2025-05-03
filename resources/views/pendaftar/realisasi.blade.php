@extends('layout.admin')

@section('title', 'Realisasi Layanan')

@section('content')

<div class="p-6 bg-white shadow-md rounded-md">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-gray-700 uppercase bg-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis KIE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Instansi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan as $layanan )
                <tr class="bg-white border-b border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($layanan->tanggal)->translatedFormat('d F Y') }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $layanan->jenis_layanan }}
                    </td>
                    <td class="px-6 py-4">
                        {{$layanan->nama_instansi}}
                    </td>
                    <td class="px-6 py-4 w-auto space-x-2">
                        <a href="{{ route('realisasi.show', $layanan->layanan_id) }}"
                           class="edit-button text-blue-500 hover:text-blue-700 flex items-center">
                            <i class="fas fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('layanan.destroy', $layanan->layanan_id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
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
@endsection
