@extends('layout.admin')

@section('back', route('realisasi.show', $layanan->layanan_id))

@section('title', 'Edit Realisasi Layanan')

@section('content')

<div class="p-8">
    <form action="{{ route('realisasi.store', $layanan->layanan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="overflow-x-auto">
            <table class="w-full table-auto" id="layanan-table">
                <thead>
                    <tr class="text-left text-blue-800">
                        <th class="p-2">Detail</th>
                        <th class="p-2">Informasi</th>
                        <th class="p-2">Sesuai</th>
                        <th class="p-2">Input</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <!-- Jumlah Peserta -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Jumlah Peserta Hadir</td>
                        <td class="p-2" id="info-jumlah">{{ $layanan->jumlah_peserta }}</td>
                        <td class="p-2">
                            <input type="checkbox" onclick="syncInput('jumlah')">
                        </td>
                        <td class="p-2">
                            <input type="number" name="jumlah_peserta" id="input-jumlah"
                            value="{{ old('jumlah_peserta_hadir', $layanan->realisasi->jumlah_peserta_hadir ?? '') }}"
                            class="w-full border border-blue-400 rounded p-1" placeholder="Jumlah Peserta Hadir">
                        </td>
                    </tr>
                    <!-- Tempat -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Tempat</td>
                        <td class="p-2" id="info-tempat">{{ $layanan->tempat }}</td>
                        <td class="p-2">
                            <input type="checkbox" onclick="syncInput('tempat')">
                        </td>
                        <td class="p-2">
                            <input type="text" name="tempat" id="input-tempat"
                            value="{{ old('tempat_realisasi', $layanan->realisasi->tempat_realisasi ?? '') }}"
                            class="w-full border border-blue-400 rounded p-1" placeholder="Tempat">
                        </td>
                    </tr>
                    <!-- Tanggal -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Tanggal</td>
                        <td class="p-2" id="info-tanggal">{{ \Carbon\Carbon::parse($layanan->tanggal)->format('Y-m-d') }}</td>
                        <td class="p-2">
                            <input type="checkbox" onclick="syncInput('tanggal')">
                        </td>
                        <td class="p-2">
                            <input type="date" name="tanggal" id="input-tanggal"
                            value="{{ old('tanggal_realisasi', optional($layanan->realisasi)->tanggal_realisasi ? \Carbon\Carbon::parse($layanan->realisasi->tanggal_realisasi)->format('Y-m-d') : '') }}"
                            class="w-full border border-blue-400 rounded p-1">
                        </td>
                    </tr>
                    <!-- Waktu -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Waktu</td>
                        <td class="p-2" id="info-waktu">{{ $layanan->waktu }}</td>
                        <td class="p-2">
                            <input type="checkbox" onclick="syncInput('waktu')">
                        </td>
                        <td class="p-2">
                            <input type="time" name="waktu" id="input-waktu"
                            value="{{ old('waktu_realisasi', $layanan->realisasi->waktu_realisasi ?? '') }}"
                            class="w-full border border-blue-400 rounded p-1">
                        </td>
                    </tr>
                    <!-- Narasumber -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Narasumber</td>
                        <td class="p-2" id="info-narasumber">{{ $layanan->narasumber->nama_narasumber }}</td>
                        <td class="p-2">
                            <input type="checkbox" onclick="syncInput('narasumber')">
                        </td>
                        <td class="p-2">
                            <input type="text" name="narasumber" id="input-narasumber"
                            value="{{ old('narasumber', optional($layanan->realisasi)->narasumber) }}"
                            class="w-full border border-blue-400 rounded p-1" placeholder="Narasumber">
                        </td>
                    </tr>
                    <!-- Foto -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Foto</td>
                        <td class="p-2"></td>
                        <td class="p-2"></td>
                        <td class="p-2">
                            @if($layanan->realisasi && $layanan->realisasi->foto)
                                <div class="mt-2 text-sm text-gray-600">
                                    File sebelumnya: {{ $layanan->realisasi->foto }}
                                </div>
                            @endif
                            <input type="file" name="foto" accept="image/*" class="w-full border border-blue-400 rounded p-1">
                        </td>
                    </tr>
                    <!-- Laporan -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Laporan</td>
                        <td class="p-2"></td>
                        <td class="p-2"></td>
                        <td class="p-2">
                            @if($layanan->realisasi && $layanan->realisasi->laporan)
                                <div class="mt-2 text-sm text-gray-600">
                                    File sebelumnya: {{ $layanan->realisasi->laporan }}
                                </div>
                            @endif
                            <input type="file" name="laporan" class="w-full border border-blue-400 rounded p-1">
                        </td>
                    </tr>
                    <!-- Catatan -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Catatan</td>
                        <td class="p-2"></td>
                        <td class="p-2"></td>
                        <td class="p-2">
                            <textarea name="catatan" rows="4" class="w-full border border-blue-400 rounded p-1" placeholder="Catatan">{{ old('catatan', optional($layanan->realisasi)->catatan) }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-green-400 hover:bg-green-500 text-white font-semibold py-2 px-8 rounded-md">
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


<script>
    function syncInput(field) {
        const checkbox = event.target;
        const info = document.getElementById('info-' + field).innerText.trim();
        const input = document.getElementById('input-' + field);

        if (checkbox.checked) {
            input.value = info;
        } else {
            input.value = '';
        }
    }

    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
    }, 2000);
</script>
@endsection
