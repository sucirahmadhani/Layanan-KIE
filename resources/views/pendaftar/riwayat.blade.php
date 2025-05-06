@extends('layout.pendaftar')

@section('title', 'Riwayat Layanan')

@section('content')

<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-blue-900 ml-5">Riwayat Layanan</h1>
    </div>
</header>

<div class="bg-gray-100 flex justify-center items-center h-auto p-5">
    @if($layanan->isEmpty())
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm ">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Layanan Komunikasi Informasi dan Edukasi yang anda daftarkan belum terlaksana.</h5>
        <p class="mb-3 font-normal text-gray-800 ">Silakan mendaftar kegiatan layanan KIE baru dengan menekan tombol di bawah ini.</p>
        <a href="/daftar" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-600">
            Daftar
        </a>
    </div>
    @else
    <div class="w-full max-w-10xl mt-0 space-y-3">
        <div class="bg-white rounded-lg p-6 shadow-md mb-6">
            <table class="w-full text-sm text-left rtl:text-right">
                <thead class="text-xs text-gray-700 uppercase bg-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jenis KIE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Topik
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Instansi
                        </th>
                        <th scope="col" class="px-6 py-4 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($layanan as $layanan )
                    <tr class="bg-white border-b border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($layanan->tanggal)->translatedFormat('d F Y') }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $layanan->jenis_layanan }}
                        </td>
                        <td class="px-6 py-4">
                            {{$layanan->nama_instansi}}
                        </td>
                        <td class="px-6 py-4">
                            @foreach($layanan->topik as $index => $topik)
                                <span class="bg-blue-200 text-blue-900 px-2 py-1 rounded-md mb-2">{{ $topik->judul }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('riwayat.detail', $layanan->layanan_id) }}" class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600 items-center">
                                LIHAT
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    @endif
</div>


@endsection
