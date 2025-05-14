@if(session('show_survey_modal'))
    <div id="survey-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full text-center">
            <h2 class="text-lg font-semibold mb-4">Terima kasih atas penilaian Anda 🙏</h2>
            <p class="mb-4">Silakan isi survei berikut untuk membantu kami meningkatkan layanan.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ session('link_survey') }}" target="_blank" class="btn btn-success">📝 Buka Survei</a>
                <a href="{{ auth()->user()->role == 'peserta' ? route('peserta.dashboard') : route('pendaftar.dashboard') }}" class="btn btn-secondary">🏠 Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script>
        // Opsional: tutup modal jika klik di luar area modal
        window.addEventListener('click', function (e) {
            const modal = document.getElementById('survey-modal');
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
@endif
