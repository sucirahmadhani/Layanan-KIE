@extends('layout.admin')


@section('back', route('layanan.permintaan'))

@section('title', 'Edit Permintaan')

@section('content')

<div class="bg-gray-100 flex justify-center items-center h-auto">
    <div class="w-full max-w-10xl">
        <div class="bg-white rounded-lg p-6">
            <div class="col-span-2 bg-gray-100 ml-20 p-6 rounded-lg">
                <div class="grid grid-cols-2 gap-3">
                    <p class="font-semibold">Jenis Layanan</p> <p>{{ $layanan->jenis_layanan }}</p>
                    <p class="font-semibold">Kategori Peserta</p> <p>{{ $layanan->kategori->nama ?? '-' }}</p>
                    <p class="font-semibold">Nama Organisasi</p> <p>{{ $layanan->nama_instansi }}</p>
                    <p class="font-semibold">Topik</p>
                    <p>
                        @foreach($layanan->topik as $topik)
                            <span class="bg-blue-200 text-blue-900 px-2 py-1 rounded-md">{{ $topik->judul }}</span>
                        @endforeach
                    </p>
                    <p class="font-semibold">Jumlah Peserta</p> <p>{{ $layanan->jumlah_peserta }}</p>
                    <p class="font-semibold">Tempat</p> <p>{{ $layanan->tempat }}</p>
                    <p class="font-semibold">Minggu</p> <p>{{ $layanan->minggu }}</p>
                    <p class="font-semibold">Bulan</p> <p>{{ $layanan->bulan }}</p>
                    <p class="font-semibold">Waktu</p> <p>{{ $layanan->waktu }}</p>
                    <p class="font-semibold">Opsi Tanggal</p> <p>{{ $layanan->opsi_tanggal  ? \Carbon\Carbon::parse($layanan->opsi_tanggal)->translatedFormat('d F Y') : '-' }}</p>
                    <p class="font-semibold">Surat</p>
                    <p>
                        <a href="{{ asset('storage/surat_layanan/' . $layanan->surat) }}"
                           class="cursor-pointer"
                           target="_blank">
                           {{ $layanan->surat }}
                        </a>
                    </p>
                </div>
                <form action="{{ route('layanan.update', $layanan->layanan_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4 mt-5">
                        <div>
                            <label class="block text-sm font-medium mb-2">Tanggal</label>
                            <input id="datepicker" type="date" name="tanggal" value="{{ $layanan->tanggal }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Status</label>
                            <select name="status" class="w-full border rounded-lg p-2">
                                <option value="Menunggu Konfirmasi" {{ $layanan->status->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="Disetujui" {{ $layanan->status->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ $layanan->status->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="Selesai" {{ $layanan->status->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Narasumber</label>
                            <select name="narasumber_id" class="w-full border rounded-lg p-2">
                                <option value="{{ $layanan->narasumber_id }}" selected>{{ optional($layanan->narasumber)->nama_narasumber ?? 'Pilih Narasumber' }}</option>
                                @foreach($narasumber as $p)
                                    <option value="{{ $p->narasumber_id }}">{{ $p->nama_narasumber }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Link Survey</label>
                            <input type="text" name="link_survey" value=" {{ $layanan->link_survey }}" class="w-full border rounded-lg p-2"></input>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Link Daftar Hadir</label>
                            <input type="text" name="link_absence" value="{{ $layanan->link_absence }}" class="w-full border rounded-lg p-2"></input>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Catatan</label>
                            <textarea name="catatan" class="w-full border rounded-lg p-2 h-24">{{ $layanan->status->catatan ?? '' }}</textarea>
                        </div>

                    </div>
                    <div class="col-span-1 md:col-span-2 flex justify-end mt-5">
                        <button type="submit" class="bg-green-500 font-semibold text-white px-5 py-2 rounded hover:bg-green-600">Simpan</button>
                    </div>
                </form>

            </div>
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
