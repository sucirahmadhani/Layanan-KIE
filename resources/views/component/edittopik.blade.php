<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-blue-900 text-white p-6 rounded-lg w-1/3">

        <h2 class="text-lg font-bold text-center mb-4">EDIT TOPIK</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label text-white">Judul Topik</label>
                <input type="text" id="editJudul" name="judul" class="form-control border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="form-label">Tahun</label>
                <select id="editTahun" name="tahun" class="form-control">
                    @for ($year = date('Y'); $year >= 2024; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded-md mr-2">Batal</button>
                <button type="submit" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, judul, tahun) {
        document.getElementById('editJudul').value = judul;
        document.getElementById('editTahun').value = tahun;
        document.getElementById('editForm').action = `/topik/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
