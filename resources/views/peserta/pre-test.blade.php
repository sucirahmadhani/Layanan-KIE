@extends('peserta.peserta')

@section('title', 'Pre-test')

@section('content')
<div class="p-8 min-h-screen bg-gray-100">
    <h1 class="text-2xl font-bold text-[#2B4570] mb-3">Pre-test</h1>

    <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-[#2B4570] mb-4">{{ $topik->judul }}</h2>

        <form method="POST" action="{{ $isLastTopik ? route('pretest.submit', [$layananId]) : route('pretest.next', [$layananId, $topikId]) }}">
            @csrf

            @foreach($soals as $index => $soal)
                <div class="mb-6">
                    <p class="text-base font-medium mb-2">{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>

                    @php
                        $opsi = json_decode($soal->opsi_salah ?? '[]', true);
                        $opsi[] = $soal->opsi_benar;
                        shuffle($opsi);
                    @endphp

                    @foreach($opsi as $i => $item)
                        <div class="flex items-center mb-1">
                            <input type="radio"
                                   name="jawaban[{{ $soal->id }}]"
                                   id="soal_{{ $soal->id }}_opsi_{{ $i }}"
                                   value="{{ $item }}"
                                   class="w-3 h-3 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                   required>
                            <label class="ms-2 cursor-pointer text-sm mb-1" for="soal_{{ $soal->id }}_opsi_{{ $i }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    {{ $isLastTopik ? 'Selesai' : 'Selanjutnya' }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

