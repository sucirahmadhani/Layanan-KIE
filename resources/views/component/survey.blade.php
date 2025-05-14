<!-- Main modal -->
<div id="survey-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm ">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 ">
                    Survei
                </h3>
            </div>
            <form class="p-4 md:p-5" action="{{ auth()->user()->role == 'peserta' ? route('survey.submit') : route('rating.submit') }}" method="POST">
                @csrf
                <div class="grid gap-4 mb-10 grid-cols-2">
                    <div class="col-span-2">
                        <label for="rating" class="block mb-2 text-sm font-medium text-gray-900 ">Seberapa puas anda dengan layanan dan sistem ini?</label>
                        <input type="hidden" name="rating" id="rating" value="0">
                        <div class="flex items-center" id="starContainer">
                            @for ($i = 1; $i <= 5; $i++)
                            <svg data-value="{{ $i }}" class="star w-8 h-8 ms-3 text-gray-300 hover:text-yellow-400 cursor-pointer"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Kirim
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');

    stars.forEach((star, idx) => {
        star.addEventListener('click', () => {
            const rating = star.dataset.value;
            ratingInput.value = rating;

            // Reset semua ke abu-abu dulu
            stars.forEach(s => s.classList.remove('text-yellow-300'));
            stars.forEach(s => s.classList.add('text-gray-300'));

            // Warnai bintang yang dipilih
            for (let i = 0; i < rating; i++) {
                stars[i].classList.remove('text-gray-300');
                stars[i].classList.add('text-yellow-300');
            }
        });
    });
</script>
