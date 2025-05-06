@extends('layout.admin')

@section('back', route('soal.show', ['topik' => $topik->id]))

@section('title', 'Tambah Soal')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <form action="{{ route('soal.store', ['topik' => $topik->id]) }}" method="POST" id="soalForm">
        @csrf
        <div id="soalContainer" class="space-y-8">
            {{-- Satu blok soal --}}
            <div class="soal-item bg-white p-6 rounded-lg shadow relative space-y-3">
                <div class="flex items-start gap-3">
                    <label class="block text-gray-900 font-medium w-1/4 pt-2">Pertanyaan</label>
                    <textarea name="soal[0][pertanyaan]" rows="4" class="w-3/4 border border-blue-300 rounded p-2" placeholder="Masukkan pertanyaan" required></textarea>
                </div>

                <div class="flex items-center gap-3">
                    <label class="block text-gray-900 font-medium w-1/4">Pilihan Benar</label>
                    <input type="text" name="soal[0][opsi_benar]" class="w-3/4 border border-blue-300 rounded p-2" placeholder="Masukkan pilihan jawaban yang benar" required>
                </div>

                @for ($i = 1; $i <= 3; $i++)
                <div class="flex items-center gap-3">
                    <label class="block text-gray-900 font-medium w-1/4">Pilihan Salah</label>
                    <input type="text" name="soal[0][opsi_salah][]" class="w-3/4 border border-blue-300 rounded p-2" placeholder="Masukkan pilihan jawaban yang salah" required>
                </div>
                @endfor

                <div class="flex items-center gap-3">
                    <label class="block text-gray-900 font-medium w-1/4">Tampilkan soal di tes?</label>
                    <select name="soal[0][tampilkan]" class="w-3/4 p-2 border rounded" required>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>

                <button type="button" class="hapus-soal text-red-600 absolute top-0 right-4 hover:underline hidden">
                    Hapus
                </button>
            </div>

        </div>

        <div class="col-span-1 md:col-span-2 flex flex-col items-end gap-2">
            <div class="mt-1">
                <button type="button" id="tambahSoal" class="text-[#2B4570] font-semibold hover:underline">
                    Tambah soal baru
                </button>
            </div>
            <div class="mt-5">
                <button type="submit" class="bg-green-400 text-white px-6 py-2 rounded hover:bg-green-500">
                    Simpan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    let soalIndex = 1;

    document.getElementById('tambahSoal').addEventListener('click', function () {
        const container = document.getElementById('soalContainer');
        const template = container.querySelector('.soal-item').cloneNode(true);

        template.querySelectorAll('textarea, input, select').forEach(function (el) {
            const name = el.getAttribute('name');
            if (name) {
                const updated = name.replace(/\[\d+\]/, `[${soalIndex}]`);
                el.setAttribute('name', updated);
                el.value = '';
            }
        });

        template.querySelector('.hapus-soal').classList.remove('hidden');

        container.appendChild(template);
        soalIndex++;
    });

    document.getElementById('soalContainer').addEventListener('click', function (e) {
        if (e.target.classList.contains('hapus-soal')) {
            e.target.closest('.soal-item').remove();
        }
    });
</script>
@endsection
