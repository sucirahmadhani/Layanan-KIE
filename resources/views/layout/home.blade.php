@extends('layout.pendaftar')

@section('title', 'Beranda')

@section('content')
<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-blue-900 ml-5">Beranda</h1>
    </div>
</header>

<div class="p-4 sm:p-8 min-h-screen bg-gray-100">
    @if($layananList->isEmpty())
        <section class="bg-white ">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
                <h1 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-2xl lg:text-3xl">Terima Kasih telah mendaftar di Sistem Layanan Komunikasi Informasi dan Edukasi <br>
                Balai Besar POM di Padang</h1>
                <p class="mb-8 text-base sm:text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-36">
                    Dapatkan Edukasi yang berkualitas dengan mendaftarkan organisasi anda pada kegiatan Layanan Komunikasi Informasi dan Edukasi yang diselenggarakan Balai Besar POM di Padang
                </p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                    <a href="/daftar" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300">
                        Daftar di sini
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @else

    @foreach($layananList as $layanan)
    <div class="bg-white p-6 rounded-lg shadow-md mb-6 max-w-7xl mx-auto">
        <h2 class="text-xl font-semibold mb-7 tracking-tight text-green-600"> Kegiatan {{ $layanan->jenis_layanan }} bersama {{ $layanan->nama_instansi }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2">
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
                            <span class="{{ $colors[$index % count($colors)] }} text-blue-900 px-2 py-1 rounded-md inline-block mb-2">{{ $topik->judul }}</span>
                        @endforeach
                    </div>

                    <div class="font-semibold">Tempat</div>
                    <div>{{ $layanan->tempat }}</div>

                    <div class="font-semibold">Tanggal</div>
                    <div>{{ \Carbon\Carbon::parse($layanan->tanggal)->translatedFormat('d F Y') }}</div>

                    <div class="font-semibold">Waktu</div>
                    <div>{{ $layanan->waktu }}</div>

                    <div class="font-semibold">Narasumber</div>
                    <div>{{ $layanan->narasumber->nama_narasumber }}</div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($layanan->tes && $layanan->tes->skor_pretest !== null)
                        <div class="bg-purple-100 text-center p-4 rounded shadow w-full">
                            <div class="text-lg font-semibold">Skor Pre-Test</div>
                            <div class="text-2xl font-bold text-purple-800">
                                {{ $layanan->tes->skor_pretest ?? '-' }}/100
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-100 rounded w-full p-4"></div>
                    @endif

                    <div class="bg-blue-200 text-center p-4 rounded shadow w-full">
                        <div class="text-lg font-semibold">Hari kegiatan</div>
                        <div class="text-3xl font-bold text-blue-800">{{ $layanan->labelHariKegiatan }}</div>
                    </div>

                    @if($layanan->tes && $layanan->tes->skor_posttest !== null)
                        <div class="bg-purple-100 text-center p-4 rounded shadow w-full">
                            <div class="text-lg font-semibold">Skor Post-Test</div>
                            <div class="text-2xl font-bold text-purple-800">
                                {{ $layanan->tes->skor_posttest ?? '-' }}/100
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-100 rounded w-full p-4"></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex flex-wrap justify-end space-x-3 mt-4 gap-2">
            @if ($layanan->hariKegiatan >= -1 && $layanan->hariKegiatan <= 1 && $layanan->link_absence)
                <a href="{{ $layanan->link_absence }}" target="_blank"
                    class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded whitespace-nowrap">
                    Absen
                </a>
            @endif

            @if ($layanan->hariKegiatan <= 0)
                @if ($layanan->jenis_layanan === 'KIE di BBPOM Padang' && $layanan->topikPertama)
                    @if(!$layanan->tes || is_null($layanan->tes->skor_pretest))
                        <a href="{{ route('pendaftar.pretest', ['layananId' => $layanan->layanan_id, 'topikId' => $layanan->topikPertama->id]) }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded whitespace-nowrap">
                            Pre-Test
                        </a>
                    @elseif(is_null($layanan->tes->skor_posttest))
                        <a href="{{ route('pendaftar.postest', ['layananId' => $layanan->layanan_id, 'topikId' => $layanan->topikPertama->id]) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded whitespace-nowrap">
                            Post-Test
                        </a>
                    @else
                        @if($layanan->tes->skor_posttest > 80)
                            <a href="{{ route('sertifikat.generate', ['layananId' => $layanan->layanan_id]) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded whitespace-nowrap">
                                Unduh Sertifikat
                            </a>
                        @else
                            <a href="{{ route('pendaftar.postest', ['layananId' => $layanan->layanan_id, 'topikId' => $layanan->topikPertama->id]) }}"
                                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded whitespace-nowrap">
                                Ulangi Post-Test
                            </a>
                        @endif
                    @endif
                @endif
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
    @endforeach
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
