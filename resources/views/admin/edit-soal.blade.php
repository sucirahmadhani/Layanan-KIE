@extends('layout.admin')

@section('back', route('soal.show', $soal->topik_id))

@section('title', 'Edit Soal')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <form action="{{ route('soal.update', $soal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 rounded-lg shadow space-y-3">
            <div class="flex items-start gap-3">
                <label class="block text-gray-900 font-medium w-1/4 pt-2">Pertanyaan</label>
                <textarea name="pertanyaan" rows="5" class="w-3/4 border border-blue-300 rounded p-2" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <label class="block text-gray-900 font-medium w-1/4">Pilihan Benar</label>
                <input type="text" name="opsi_benar" class="w-3/4 border border-blue-300 rounded p-2" value="{{ old('opsi_benar', $soal->opsi_benar) }}" required>
            </div>

            @foreach ($soal->opsi_salah as $index => $opsi)
                <div class="flex items-center gap-3">
                    <label class="block text-gray-900 font-medium w-1/4">Pilihan Salah {{ $index + 1 }}</label>
                    <input type="text" name="opsi_salah[]" class="w-3/4 border border-blue-300 rounded p-2" value="{{ old("opsi_salah.$index", $opsi) }}" required>
                </div>
            @endforeach

            <div class="flex items-center gap-3">
                <label class="block text-gray-900 font-medium w-1/4">Tampilkan soal di tes?</label>
                <select name="tampilkan" class="w-3/4 p-2 border rounded" required>
                    <option value="1" {{ $soal->tampilkan ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ !$soal->tampilkan ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Update Soal
                </button>
            </div>
        </div>
    </form>
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
