@extends('layout.pendaftar')

@section('title', 'Daftar Layanan')

@section('content')
<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-blue-900 ml-5">Daftar Layanan</h1>
    </div>
</header>

<div class="max-w-8xl mx-auto my-5 bg-white p-10 rounded-lg">
    <form action="/daftar/store" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf
        <div>
            <label class="block text-gray-700 mb-2">Jenis Layanan</label>
            <select name="jenis_layanan" class="w-full p-2 border rounded">
                <option disabled selected>Pilih Jenis Layanan</option>
                <option value="KIE di BBPOM Padang">KIE di BBPOM Padang</option>
                <option value="KIE di luar BBPOM Padang">KIE di luar BBPOM Padang</option>
                <option value="KIETOMAS (Komunikasi Informasi Edukasi Bersama Tokoh Masyarakat)">KIETOMAS (Komunikasi Informasi Edukasi Bersama Tokoh Masyarakat)</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Nama Organisasi</label>
            <input type="text" name="nama_instansi" class="w-full p-2 border rounded" placeholder="Masukkan Nama Organisasi">
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Kategori Peserta</label>
            <select name="kategori_id" class="w-full p-2 border rounded">
                <option>Pilih Kategori Peserta</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Tempat</label>
            <input name="tempat" type="text" class="w-full p-2 border rounded" placeholder="Masukkan Tempat">
        </div>
        <div x-data="{ selected: [], open: false }" class="relative">
            <label class="block text-gray-700 mb-2">Topik</label>
            <button type="button" @click="open = !open" class="w-full p-2 border rounded bg-white text-left">
                <span x-text="selected.length ? selected.map(id => $refs[`label_${id}`].textContent).join(', ') : 'Pilih Topik'"></span>
                <svg class="w-3 h-3 inline float-right mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute z-10 w-full bg-white border rounded shadow-md mt-1">
                <ul class="max-h-48 overflow-y-auto p-2">
                    @foreach ($topik as $item)
                    <li class="flex items-center p-2 hover:bg-gray-100">
                        <label class="flex items-center w-full cursor-pointer">
                            <input type="checkbox" value="{{ $item->id }}" x-model="selected"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-200">
                            <span class="ml-2 text-sm" x-ref="label_{{ $item->id }}">{{ $item->judul }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
            <template x-for="id in selected" hidden>
                <input type="hidden" name="topik[]" :value="id">
            </template>
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Jumlah Peserta</label>
            <input name="jumlah_peserta" type="number" class="w-full p-2 border rounded" placeholder="Masukkan Jumlah Peserta">
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Minggu ke</label>
            <select name="minggu" class="w-full p-2 border rounded">
                <option disabled selected>Pilih Minggu</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Waktu</label>
            <input name="waktu" type="time" class="w-full p-2 border rounded" placeholder="Masukkan Waktu">
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Bulan</label>
            <select name="bulan" class="w-full p-2 border rounded">
                <option disabled selected>Pilih Bulan</option>
                <option value="Januari">Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <option value="Mei">Mei</option>
                <option value="Juni">Juni</option>
                <option value="Juli">Juli</option>
                <option value="Agustus">Agustus</option>
                <option value="September">September</option>
                <option value="Oktober">Oktober</option>
                <option value="November">November</option>
                <option value="Desember">Desember</option>
            </select>
        </div>
        <div class="w-full ">
            <label class="block mb-2 text-sm font-medium text-gray-700 " for="user_avatar">Upload Surat</label>
            <input name="surat" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
        </div>
        <div>
            <label class="block text-gray-700 mb-2">Opsi Tanggal</label>
            <input name="opsi_tanggal" type="date" class="w-full p-2 border rounded" placeholder="Tanggal yang disarankan, boleh dikosongkan">
        </div>
        <div class="col-span-1 md:col-span-2 flex justify-end">
            <button type="submit" class="bg-green-500 text-base font-semibold text-white px-6 py-3 rounded hover:bg-green-600">Daftar</button>
        </div>
    </form>
</div>



@endsection
