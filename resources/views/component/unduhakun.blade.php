<div id="unduhakun-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-blue-900 text-white rounded-lg shadow-sm">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h2 class="text-lg font-bold text-center w-full">
                    Pilih Jumlah Akun yang Digenerate
                </h2>
            </div>
            <div class="p-4 md:p-5">
                <form action="{{ route('generate.akun') }}" method="POST" id="downloadForm">
                    @csrf
                    <input type="hidden" name="layanan_id" value="{{ $item->layanan_id }}">
                    <div class="mb-4">
                        <label class="form-label">Jumlah Akun</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" min="1" max="{{ $item->jumlah_peserta }}" required>
                    </div>
                    <div class="flex justify-end mt-4 space-x-2">
                        <button type="button" id="closeModal" data-modal-hide="unduhakun-modal" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">Batal</button>
                        <button type="submit" id="generateAndCloseButton" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">Generate & Unduh</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('generateAndCloseButton').addEventListener('click', function() {
        // Tutup modal manual
        const modal = document.getElementById('unduhakun-modal');
        if (modal) {
            modal.classList.add('hidden');
        }

        // Tunggu 300ms biar modal beneran nutup
        setTimeout(function() {
            document.getElementById('generateForm').submit();
        }, 300);
    });
</script>


