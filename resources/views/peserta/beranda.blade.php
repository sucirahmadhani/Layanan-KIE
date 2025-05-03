@extends('peserta.peserta')

@section('title', 'Beranda')

@section('content')

<div class="p-8 min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
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
                    <div class="bg-red-200 text-center p-4 rounded shadow w-full">
                        <div class="text-2xl font-bold">
                            {{ $labelHariKegiatan }}
                        </div>
                        <div>Hari kegiatan</div>
                    </div>
                    <div class="bg-blue-200 text-center p-4 rounded shadow w-full">
                        <div class="text-2xl font-bold">
                            D-{{ (int) ($hariNonaktif >= 0 ? $hariNonaktif : 0) }}
                        </div>
                        <div>Akun nonaktif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-0">
            @if ($topikPertama)
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
            @endif
        </div>
    </div>
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">{{ $errors->first() }}</span>
    @endif

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
@include('component.survey')
@endsection


