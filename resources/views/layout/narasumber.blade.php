@extends('layout.admin')

@section('title', 'Narasumber')

@section('content')
<div class="p-6 bg-white shadow-md rounded-md">
    <div class="flex justify-end items-center mb-4">
        <button data-modal-target="addemployee-modal" data-modal-toggle="addemployee-modal" class="block text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
            Tambah Narasumber
        </button>
        @include('component.tambahpegawai')
    </div>


    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-gray-700 uppercase bg-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Instansi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jabatan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No HP
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Keahlian
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($narasumber as $narasumber )
                <tr class="bg-white border-b border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{$narasumber->nama_narasumber}}
                    </th>
                    <td class="px-6 py-4">
                        {{ $narasumber->instansi }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $narasumber->jabatan }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $narasumber->email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $narasumber->no_hp }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $narasumber->keahlian }}
                    </td>
                    <td class="px-6 py-4 w-auto space-x-2">
                        <button class="edit-button text-blue-500 hover:text-blue-700 flex items-center"
                            data-modal-target="editemployee-modal"
                            data-modal-toggle="editemployee-modal"
                            data-id="{{ $narasumber->narasumber_id }}"
                            data-nama="{{ $narasumber->nama_narasumber }}"
                            data-instansi="{{ $narasumber->instansi }}"
                            data-jabatan="{{ $narasumber->jabatan }}"
                            data-email="{{ $narasumber->email }}"
                            data-nohp="{{ $narasumber->no_hp }}"
                            data-keahlian="{{ $narasumber->keahlian }}">
                            <i class="fas fa-pen-to-square"></i>
                        </button>

                        @include('component.editpegawai')

                        <form action="{{ route('narasumber.destroy', $narasumber->narasumber_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
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
        <div class="flex items-center p-4 text-green-800 bg-green-100 rounded-lg shadow">
            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="3" d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if ($errors->any())
    <div id="toast-error" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="flex items-center p-4 text-red-800 bg-red-100 rounded-lg shadow">
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
