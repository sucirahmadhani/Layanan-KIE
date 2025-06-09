
<!-- Modal Konfirmasi Selesai -->
<div id="selesaiModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-md shadow-lg p-6 w-full max-w-md text-center">
        <h2 class="text-lg font-semibold mb-4">Konfirmasi</h2>
        <p class="mb-6">Apakah kegiatan sudah terlaksana?</p>
        <div class="flex justify-center gap-4">
            <button onclick="submitSelesai()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Ya, selesai
            </button>
            <button onclick="closeSelesaiModal()" class="bg-gray-400 hover:bg-gray-500 px-4 py-2 rounded">
                Batal
            </button>
        </div>
    </div>
</div>
