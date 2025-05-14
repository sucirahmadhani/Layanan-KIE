@php
    $colors = ['bg-blue-200', 'bg-green-200', 'bg-yellow-200', 'bg-red-200', 'bg-purple-200'];
@endphp

@extends('layout.pendaftar')

@section('title', 'Detail Riwayat Layanan')

@section('content')

<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-0 py-4 sm:px-6 lg:px-8 flex items-center">
        <a href="{{ route('riwayat') }}" class="text-blue-900 hover:text-blue-600 mr-8">
          <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold tracking-tight text-blue-900">Detail Riwayat Layanan</h1>
    </div>
</header>

<div class="bg-gray-100 flex justify-center items-center h-auto p-5">
    <div class="w-full max-w-10xl mt-0 space-y-3">
            <div class="bg-white rounded-lg p-10 shadow-md mb-6">
                <div class="grid grid-cols-2 gap-20 px-20">
                    <div class="space-y-2">
                        <h2 class="text-lg font-bold text-blue-800 mb-4">Detail</h2>
                        <div class="grid grid-cols-2 gap-x-4">
                            <div class="font-semibold">Jenis Layanan</div>
                            <div>{{ $layanan->jenis_layanan }}</div>

                            <div class="font-semibold">Kategori Peserta</div>
                            <div>{{ $layanan->kategori->nama ?? '-' }}</div>

                            <div class="font-semibold">Nama Organisasi</div>
                            <div>{{ $layanan->nama_instansi }}</div>

                            <div class="font-semibold">Topik</div>
                            <div>
                                @foreach($layanan->topik as $index => $topik)
                                    <span class="{{ $colors[$index % count($colors)] }} text-blue-900 px-2 py-1 rounded-md mb-2">{{ $topik->judul }}</span>
                                @endforeach
                            </div>

                            <div class="font-semibold">Jumlah Peserta</div>
                            <div>{{ $layanan->jumlah_peserta }}</div>

                            <div class="font-semibold">Narasumber</div>
                            <div>{{ $layanan->narasumber->nama_narasumber }}</div>

                            <div class="font-semibold">Tempat</div>
                            <div>{{ $layanan->tempat }}</div>

                            <div class="font-semibold">Tanggal</div>
                            <div> {{ \Carbon\Carbon::parse($layanan->tanggal)->translatedFormat('d F Y') }}</div>

                            <div class="font-semibold">Waktu</div>
                            <div>{{ $layanan->waktu }}</div>

                            <div class="font-semibold">Surat</div>
                            <div>
                                <a href="{{ asset('storage/surat_layanan/' . $layanan->surat) }}" class="cursor-pointer" target="_blank">
                                    {{ $layanan->surat }}
                                </a>
                            </div>
                        </div>
                    </div>


                    <!-- Realisasi Section (Right) -->
                    <div class="space-y-2">
                        <h2 class="text-lg font-bold text-blue-800 mb-4">Realisasi</h2>
                        <div class="grid grid-cols-2 gap-x-4">
                            <div class="font-semibold">Jumlah Peserta Hadir</div>
                            <div>{{ $layanan->realisasi->jumlah_peserta_hadir ?? '-' }}</div>

                            <div class="font-semibold">Tempat</div>
                            <div>{{ $layanan->realisasi->tempat_realisasi ?? '-' }}</div>

                            <div class="font-semibold">Tanggal</div>
                            <div>
                                <p>{{ $layanan->realisasi && $layanan->realisasi->tanggal_realisasi ? \Carbon\Carbon::parse($layanan->realisasi->tanggal_realisasi)->translatedFormat('d F Y') : '-' }}</p>
                            </div>

                            <div class="font-semibold">Waktu</div>
                            <div>{{ $layanan->realisasi->waktu_realisasi ?? '-' }}</div>

                            <div class="font-semibold">Narasumber</div>
                            <div>{{ $layanan->realisasi->narasumber ?? '-' }}</div>

                            <div class="font-semibold">Foto</div>
                            <div>
                                @if($layanan->realisasi && $layanan->realisasi->foto)
                                    <a href="{{ asset('storage/' . $layanan->realisasi->foto) }}" target="_blank" class="text-blue-600 underline">{{ $layanan->realisasi->foto }}</a>
                                @else
                                    -
                                @endif
                            </div>
                            @if($layanan->jenis_layanan === 'KIE di BBPOM Padang' && $tes)
                                <div class="bg-red-200 text-center p-4 mt-3 rounded shadow w-full">
                                    <div class="text-2xl font-bold">
                                        {{ $tes->skor_pretest }}/100
                                    </div>
                                    <div>Skor Pre-test</div>
                                </div>
                                <div class="bg-blue-200 text-center p-4 mt-3 rounded shadow w-full">
                                    <div class="text-2xl font-bold">
                                        {{ $tes->skor_posttest }}/100
                                    </div>
                                    <div>Skor Post-test</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($layanan->jenis_layanan === 'KIE di BBPOM Padang')
                    <div class="flex justify-end mt-10">
                        <a href="{{ route('sertifikat.generate', ['layananId' => $layanan->layanan_id]) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                            Unduh Sertifikat
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


