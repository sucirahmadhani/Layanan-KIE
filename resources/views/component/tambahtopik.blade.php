<div x-data="{ openModal: false }">
    <div class="flex justify-end">
        <button @click="openModal = true" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
            Tambah Topik
        </button>
    </div>

    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div @click.away="openModal = false" class="bg-blue-900 text-white p-6 rounded-lg w-1/3">
            <h2 class="text-lg font-bold text-center mb-4">TAMBAH TOPIK</h2>

            <form action="/topik" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Judul Topik</label>
                    <input type="text" name="judul" class="form-control  border-gray-300 rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="form-label">Tahun</label>
                    <select id="tahun" name="tahun" class="form-control"></select>
                </div>

                <div class="flex justify-end">
                    <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-300 rounded-md mr-2">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const selectTahun = document.getElementById('tahun');
    const currentYear = new Date().getFullYear();

    for (let year = 2025; year <= currentYear; year++) {
        let option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        selectTahun.appendChild(option);
    }
</script>
