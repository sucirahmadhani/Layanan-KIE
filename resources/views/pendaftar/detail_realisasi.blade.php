@php
    $colors = ['bg-blue-200', 'bg-green-200', 'bg-yellow-200', 'bg-red-200', 'bg-purple-200'];
@endphp

@extends('layout.admin')

@section('back', route('realisasi'))

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

                       @if($layanan->jenis_layanan === 'KIE di BBPOM Padang')
                            @if($averageRating)
                                <div class="font-semibold">Rata-rata Rating</div>
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.217 3.737a1 1 0 00.95.69h3.923c.969 0 1.371 1.24.588 1.81l-3.178 2.31a1 1 0 00-.364 1.118l1.217 3.737c.3.921-.755 1.688-1.54 1.118l-3.178-2.31a1 1 0 00-1.176 0l-3.178 2.31c-.784.57-1.838-.197-1.539-1.118l1.216-3.737a1 1 0 00-.364-1.118l-3.178-2.31c-.783-.57-.38-1.81.588-1.81h3.922a1 1 0 00.951-.69l1.217-3.737z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-700">({{ $averageRating }} dari 5)</span>
                                </div>
                            @endif

                            @if($averagePretest)
                                <div class="font-semibold">Rata-rata Skor Pre-Test</div>
                                <div>{{ $averagePretest }} dari 100</div>
                            @endif

                            @if($averagePosttest)
                                <div class="font-semibold">Rata-rata Skor Post-Test</div>
                                <div>{{ $averagePosttest }} dari 100</div>
                            @endif
                        @endif
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
                                <a href="{{ asset('storage/uploads/foto_realisasi/' . $layanan->realisasi->foto) }}" class="cursor-pointer" target="_blank">{{ $layanan->realisasi->foto }}</a>
                            @else
                                -
                            @endif
                        </div>

                        <div class="font-semibold">Laporan</div>
                        <div>
                            @if($layanan->realisasi && $layanan->realisasi->laporan)
                                <a href="{{ asset('storage/uploads/laporan_realisasi/' . $layanan->realisasi->laporan) }}" class="cursor-pointer" target="_blank">{{ $layanan->realisasi->laporan }}</a>
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
                <a href="{{ route('realisasi.edit', $layanan->layanan_id) }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md">
                    Edit
                </a>
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


