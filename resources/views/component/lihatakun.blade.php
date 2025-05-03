<!-- Modal Lihat Akun Peserta -->
<div id="lihatakun-modal-{{ $item->layanan_id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Akun Peserta
                </h3>
            </div>

            <div class="p-4 md:p-5 space-y-2">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->pengguna as $peserta)
                            <tr class="bg-white border-b border-gray-200">
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $peserta->nama }}
                                </th>
                                <td class="px-6 py-2">
                                    {{ $peserta->username }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ $peserta->email }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 text-right">
                        <button type="button" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" data-modal-hide="lihatakun-modal-{{ $item->layanan_id }}">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


