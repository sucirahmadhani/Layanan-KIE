@extends('peserta.peserta')

@section('title', 'Beranda')

@section('content')

<div class="p-8 min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-7 tracking-tight text-green-600"> Kegiatan {{ $layanan->jenis_layanan }} bersama {{ $layanan->nama_instansi }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-2 gap-10">
            <div class="space-y-2">
                <div class="grid grid-cols-2 gap-x-4">
                    <div class="font-semibold">Jenis Layanan</div>
                    <div>{{ $layanan->jenis_layanan}}</div>

                    <div class="font-semibold">Nama Organisasi</div>
                    <div>{{ $layanan->nama_instansi }}</div>

                    <div class="font-semibold">Topik</div>
                    <div>
                        @php
                            $colors = ['bg-yellow-200', 'bg-green-200', 'bg-red-200', 'bg-blue-200'];
                        @endphp

                        @foreach($layanan->topik as $index => $topik)
                            <span class="{{ $colors[$index % count($colors)] }} text-blue-900 px-2 py-1 rounded-md mb-2">{{ $topik->judul }}</span>
                        @endforeach
                    </div>

                    <div class="font-semibold">Tempat</div>
                    <div>{{ $layanan->tempat }}</div>

                    <div class="font-semibold">Tanggal</div>
                    <div> {{ \Carbon\Carbon::parse($layanan->tanggal)->translatedFormat('d F Y') }}</div>

                    <div class="font-semibold">Waktu</div>
                    <div>{{ $layanan->waktu }}</div>

                    <div class="font-semibold">Narasumber</div>
                    <div>{{ $layanan->narasumber->nama_narasumber }}</div>

                    <div class="font-semibold">Pendaftar</div>
                    <div>{{ $pendaftar ? $pendaftar->nama : 'Tidak ada pendaftar' }}</div>

                </div>
            </div>

            <div class="flex flex-col  gap-4">
                <div class="grid grid-cols-2 gap-x-4">
                    @php
                        $labelHariKegiatan = (int) $hariKegiatan >= 0 ? 'D-' . (int) $hariKegiatan : 'D+' . abs((int) $hariKegiatan);
                    @endphp
                    <div class="bg-red-100 text-center p-4 rounded shadow w-full">
                        <div class="text-lg font-semibold">Hari kegiatan</div>
                        <div class="text-2xl font-bold text-red-800">
                            {{ $labelHariKegiatan }}
                        </div>

                    </div>
                    <div class="bg-blue-100 text-center p-4 rounded shadow w-full">
                        <div class="text-lg font-semibold">Akun nonaktif</div>
                        <div class="text-2xl font-bold text-blue-800">
                            D-{{ (int) ($hariNonaktif >= 0 ? $hariNonaktif : 0) }}
                        </div>

                    </div>
                    @if($tes && $tes->skor_pretest !== null)
                        <div class="bg-purple-100 text-center p-4 rounded shadow w-full">
                            <div class="text-lg font-semibold">
                                Skor Pre-Test
                            </div>
                            <div class="text-2xl font-bold text-purple-800">
                                {{ $tes->skor_pretest ?? '-' }}/100
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-x-4">
                            <div class="bg-white-200 text-center p-4 rounded  w-full">
                            </div>
                        </div>
                    @endif

                    @if($tes && $tes->skor_posttest !== null)
                        <div class="bg-pink-100 text-center p-4 rounded shadow w-full">
                            <div class="text-lg font-semibold">
                                Skor Post-Test
                            </div>
                            <div class="text-2xl font-bold text-pink-800">
                                {{ $tes->skor_posttest ?? '-' }}/100
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-x-4">
                            <div class="bg-white-200 text-center p-4 rounded  w-full">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-0 items-start space-x-2">
            @if ($hariKegiatan >= -1 && $hariKegiatan <= 1 && $layanan->link_absence)
                <div class="flex justify-end mt-4">
                    <a href="{{ $layanan->link_absence }}"
                        target="_blank"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded">
                        Absen
                    </a>
                </div>
            @endif

            @if ($layanan->jenis_layanan === 'KIE di BBPOM Padang' && $topikPertama)
            <div class="flex justify-end mt-4">
                @if(!$tes || is_null($tes->skor_pretest))
                    <a href="{{ route('pretest.index', ['layananId' => $layanan->layanan_id, 'topikId' => $topikPertama->id]) }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded">
                        Pre-Test
                    </a>
                @elseif(is_null($tes->skor_posttest))
                    <a href="{{ route('posttest.index', ['layananId' => $layanan->layanan_id, 'topikId' => $topikPertama->id]) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">
                        Post-Test
                    </a>
                @else
                    @if($tes->skor_posttest > 80)
                        <a href="{{ route('sertifikat.generate', ['layananId' => $layanan->layanan_id]) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                            Unduh Sertifikat
                        </a>
                    @else
                        <a href="{{ route('posttest.index', ['layananId' => $layanan->layanan_id, 'topikId' => $topikPertama->id]) }}"
                        class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded">
                            Ulangi Post-Test
                        </a>
                    @endif
                @endif
            </div>
            @endif
        </div>
    </div>
    @if(session('showSurveyModal'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('survey-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
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
@include('component.survey')
@include('component.link')
@endsection


