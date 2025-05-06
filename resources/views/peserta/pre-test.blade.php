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

