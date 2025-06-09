@extends('layout.admin')

@section('title', 'Permintaan')

@section('content')

<div class="p-6 bg-white shadow-md rounded-md">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-gray-700 uppercase bg-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Organisasi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jenis KIE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
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
                        {{$layanan->nama_instansi}}
                    </th>
                    <td class="px-6 py-4">
                        {{ $layanan->jenis_layanan }}
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $status = $layanan->status->status;
                            $colors = [
                                'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-800',
                                'Disetujui' => 'bg-green-100 text-green-800',
                                'Ditolak' => 'bg-red-100 text-red-800',
                            ];
                        @endphp

                        <span class="{{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }} text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 w-auto space-x-2">
                        <a href="{{ route('layanan.edit', $layanan->layanan_id) }}"
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
                        @if ($status === 'Disetujui')
                            <button type="button" onclick="openSelesaiModal('{{ $layanan->layanan_id }}')"
                                    class="text-blue-500 hover:text-blue-700 flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> Selesai
                            </button>
                        @endif
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

    let selectedLayananId = null;

    function openSelesaiModal(id) {
        selectedLayananId = id;
        document.getElementById('selesaiModal').classList.remove('hidden');
    }

    function closeSelesaiModal() {
        selectedLayananId = null;
        document.getElementById('selesaiModal').classList.add('hidden');
    }

    function submitSelesai() {
        if (!selectedLayananId) return;

        fetch(`/layanan/${selectedLayananId}/selesai`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Gagal mengubah status.');
            }
        });

        closeSelesaiModal();
    }


    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
    }, 2000);
</script>
@include('component.selesai');
@endsection


