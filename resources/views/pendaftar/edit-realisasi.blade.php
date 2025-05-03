@extends('layout.admin')

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
                            <input type="number" name="jumlah_peserta" id="input-jumlah" class="w-full border border-blue-400 rounded p-1" placeholder="Jumlah Peserta">
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
                            <input type="text" name="tempat" id="input-tempat" class="w-full border border-blue-400 rounded p-1" placeholder="Tempat">
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
                            <input type="date" name="tanggal" id="input-tanggal" class="w-full border border-blue-400 rounded p-1">
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
                            <input type="time" name="waktu" id="input-waktu" class="w-full border border-blue-400 rounded p-1">
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
                            <input type="text" name="narasumber" id="input-narasumber" class="w-full border border-blue-400 rounded p-1" placeholder="Narasumber">
                        </td>
                    </tr>
                    <!-- Foto -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Foto</td>
                        <td class="p-2"></td>
                        <td class="p-2"></td>
                        <td class="p-2">
                            <input type="file" name="foto" accept="image/*" class="w-full border border-blue-400 rounded p-1">
                            <div class="mt-2">
                                <img id="preview-foto" class="w-40 rounded" style="display: none;">
                            </div>
                        </td>
                    </tr>
                    <!-- Laporan -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Laporan</td>
                        <td class="p-2"></td>
                        <td class="p-2"></td>
                        <td class="p-2">
                            <input type="file" name="laporan" class="w-full border border-blue-400 rounded p-1">
                        </td>
                    </tr>
                    <!-- Catatan -->
                    <tr class="border-t">
                        <td class="p-2 font-semibold">Catatan</td>
                        <td class="p-2"></td>
                        <td class="p-2"></td>
                        <td class="p-2">
                            <textarea name="catatan" rows="4" class="w-full border border-blue-400 rounded p-1" placeholder="Catatan"></textarea>
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

<!-- Javascript -->
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

</script>


@endsection
