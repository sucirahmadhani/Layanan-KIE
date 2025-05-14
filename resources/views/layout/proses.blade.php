@extends('layout.pendaftar')

@section('title', 'Proses')

@section('content')
<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-blue-900 ml-5">Proses</h1>
    </div>
</header>

<div class="bg-gray-100 flex justify-center items-center h-auto p-5">
    @if($layanan->isEmpty())
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm ">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Anda belum mendaftar Layanan KIE BBPOM di Padang</h5>
        <p class="mb-3 font-normal text-gray-800 ">Silakan mendaftar dengan menekan tombol di bawah ini.</p>
        <a href="/daftar" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600">
            Daftar
        </a>
    </div>

    @else
    <div class="w-full max-w-10xl mt-0 space-y-3">
        @foreach ($layanan as $item)
        <div class="bg-white rounded-lg p-6 shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-7 tracking-tight text-green-600"> Kegiatan {{ $item->jenis_layanan }} bersama {{ $item->nama_instansi }}</h2>
            <div class="grid grid-cols-2 gap-20">
                <div class="space-y-5">
                    <div class="block text-blue-800 bg-blue-100 p-4 rounded-lg shadow-sm text-center font-semibold">{{ $item->status->status }}</div>
                    <div class="text-indigo-800 bg-indigo-100 p-4 rounded-lg shadow-sm grid grid-cols-2 gap-x-2">
                        <p class="font-semibold">Tanggal</p>
                        <p>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}</p>
                        <p class="font-semibold">Narasumber</p> <p>{{ $item->narasumber->nama_narasumber ?? 'Belum ditentukan' }}</p>
                    </div>
                    <div class="block p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100">
                        <h6 class="mb-2 text-xl font-bold tracking-tight text-gray-900">Catatan</h6>
                        <p class="font-normal text-gray-800 ">{{ $item->status->catatan ?? 'Belum ada catatan' }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="grid grid-cols-2 gap-y-4">
                        <div class="font-semibold">Jenis Layanan</div>
                        <div>{{ $item->jenis_layanan }}</div>

                        <div class="font-semibold">Kategori Peserta</div>
                        <div>{{ $item->kategori->nama ?? '-' }}</div>

                        <div class="font-semibold">Nama Organisasi</div>
                        <div>{{ $item->nama_instansi }}</div>

                        <div class="font-semibold">Topik</div>
                        <div>
                            @foreach($item->topik as $topik)
                                <span class="bg-blue-200 text-blue-900 px-2 py-1 rounded-md">{{ $topik->judul }}</span>
                            @endforeach
                        </div>

                        <div class="font-semibold">Jumlah Peserta</div>
                        <div>{{ $item->jumlah_peserta }}</div>

                        <div class="font-semibold">Tempat</div>
                        <div>{{ $item->tempat }}</div>

                        <div class="font-semibold">Minggu</div>
                        <div>{{ $item->minggu }}</div>

                        <div class="font-semibold">Bulan</div>
                        <div>{{ $item->bulan }}</div>

                        <div class="font-semibold">Waktu</div>
                        <div>{{ $item->waktu }}</div>

                        <div class="font-semibold">Surat</div>
                        <div>
                            <a href="{{ asset('storage/surat_layanan/' . $item->surat) }}" class="cursor-pointer" target="_blank">
                                {{ $item->surat }}
                            </a>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 space-x-4">
                        @if (
                            $item->status->status == 'Disetujui' &&
                            $item->jenis_layanan == 'KIE di BBPOM Padang'
                        )
                            <button data-modal-target="unduhakun-modal" data-modal-toggle="unduhakun-modal" id="unduhAkunBtn" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Unduh Akun
                            </button>
                            @include('component.unduhakun')

                            @if($item->pengguna->isNotEmpty())
                                <button data-modal-target="lihatakun-modal-{{ $item->layanan_id }}" data-modal-toggle="lihatakun-modal-{{ $item->layanan_id }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Lihat Akun Peserta
                                </button>
                                @include('component.lihatakun')
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
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
