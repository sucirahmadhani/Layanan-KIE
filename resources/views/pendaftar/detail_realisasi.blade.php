@php
    $colors = ['bg-blue-200', 'bg-green-200', 'bg-yellow-200', 'bg-red-200', 'bg-purple-200'];
@endphp

@extends('layout.admin')

@section('title', 'Detail Realisasi Layanan')

@section('content')

<div class="p-0">
    <div class="w-full max-w-10xl mt-0 space-y-3">
            <div class="bg-white rounded-lg p-6 shadow-md mb-6">
                <div class="grid grid-cols-2 gap-8">
                    <!-- Layanan Section (Left) -->
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
                    
                            <div class="font-semibold">Laporan</div>
                            <div>
                                @if($layanan->realisasi && $layanan->realisasi->laporan)
                                    <a href="{{ asset('storage/' . $layanan->realisasi->laporan) }}" target="_blank" class="text-blue-600 underline">{{ $layanan->realisasi->laporan }}</a>
                                @else
                                    -
                                @endif
                            </div>
                    
                            <div class="font-semibold">Catatan</div>
                            <div>{{ $layanan->realisasi->catatan ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-10">
                    <a href="{{ route('realisasi.edit', $layanan->layanan_id) }} " class="bg-green-400 hover:bg-green-500 text-white font-semibold py-2 px-6 rounded-md">
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


