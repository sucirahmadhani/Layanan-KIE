<!-- Edit Modal -->
<div id="editemployee-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-blue-900 text-white rounded-lg shadow-sm">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h2 class="text-lg font-bold text-center w-full">
                    EDIT NARASUMBER
                </h2>
            </div>
            <div class="p-4 md:p-5">
                <form method="POST" id="edit-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="employee_id">

                    <div class="mb-4">
                        <label class="form-label">Nama Narasumber</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control border-gray-300 rounded-lg" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Instansi</label>
                        <input type="text" name="instansi" id="edit_nip" class="form-control border-gray-300 rounded-lg" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" id="edit_jabatan" class="form-control border-gray-300 rounded-lg" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" id="edit_email" class="form-control border-gray-300 rounded-lg" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" id="edit_nohp" class="form-control border-gray-300 rounded-lg" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keahlian</label>
                        <input type="text" name="keahlian" id="edit_keahlian" class="form-control border-gray-300 rounded-lg" required />
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-300 text-white rounded-md mr-2 hover:bg-gray-400" data-modal-hide="editemployee-modal">Batal</button>
                        <button type="submit" class="px-4 py-2 text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm text-center">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-button").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.getAttribute("data-id");

            if (!id) {
                alert("ID Narasumber tidak ditemukan!");
                return;
            }

            document.getElementById("employee_id").value = id;
            document.getElementById("edit_nama").value = this.getAttribute("data-nama");
            document.getElementById("edit_nip").value = this.getAttribute("data-instansi");
            document.getElementById("edit_jabatan").value = this.getAttribute("data-jabatan");
            document.getElementById("edit_email").value = this.getAttribute("data-email");
            document.getElementById("edit_nohp").value = this.getAttribute("data-nohp");
            document.getElementById("edit_keahlian").value = this.getAttribute("data-keahlian");

            document.querySelector("#editemployee-modal form").action = "/narasumber/" + id;
        });
    });
});

</script>
