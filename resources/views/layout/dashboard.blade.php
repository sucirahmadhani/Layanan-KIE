@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')

<div class="flex flex-col w-full max-w-7xl">
    <div class="mb-4">
        <ul class="flex px-4 space-x-4">
            @foreach ($jenisLayanan as $index => $jenis)
                <li>
                    <button onclick="highlightTab({{ $index }})" id="tab-btn-{{ $index }}"
                        class="tab-btn text-green-500 font-semibold text-md hover:underline">
                        {{ $jenis->jenis_layanan }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    @foreach ($jenisLayanan as $index => $jenis)
    <div id="tab-{{ $index }}" class="tab-content {{ $index != 0 ? 'hidden' : '' }}">
        @php
            $d = $data[$jenis->jenis_layanan];
            $cardColors = $warna[$jenis->jenis_layanan]['cards'];
            $chartColors = $warna[$jenis->jenis_layanan]['chart'];
        @endphp
        <!-- Statistics Cards -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="{{ $cardColors[0] }} p-4 rounded-lg text-center shadow-md">
                <div class="text-xl font-bold">{{ $d['totalSeminar'] }}</div>
                <div>Total Layanan</div>
            </div>
            <div class="{{ $cardColors[1] }} p-4 rounded-lg text-center shadow-md">
                <div class="text-xl font-bold">{{ $d['totalPeserta'] }}</div>
                <div>Total Peserta</div>
            </div>
            <div class="{{ $cardColors[2] }} p-4 rounded-lg text-center shadow-md">
                <div class="text-xl font-bold">{{ number_format($d['persentasePartisipasi'], 2) }}%</div>
                <div>Partisipasi</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-300 p-8 rounded-lg text-center shadow-md">
                <h2 class="text-lg font-semibold text-center mb-5">Kategori Peserta</h2>
                <canvas id="kategoriChart{{ $index }}" class="w-full max-w-sm h-64 mx-auto"></canvas>
            </div>
            <div class="bg-gray-300 p-8 rounded-lg text-center shadow-md">
                <h2 class="text-lg font-semibold text-center mb-10">Topik Populer (Jumlah Layanan)</h2>
                <canvas id="topikChart{{ $index }}" class="w-full h-64 mx-auto"></canvas>
            </div>
        </div>
    </div>
    @endforeach

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function highlightTab(index) {
        // Reset semua tombol ke warna hijau
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-500');
            btn.classList.add('text-green-500');
        });

        // Ganti warna tombol aktif jadi biru
        const activeBtn = document.getElementById('tab-btn-' + index);
        if (activeBtn) {
            activeBtn.classList.remove('text-green-500');
            activeBtn.classList.add('text-blue-500');
        }

        // Sembunyikan semua tab
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Tampilkan konten tab yang dipilih
        const activeTab = document.getElementById('tab-' + index);
        if (activeTab) {
            activeTab.classList.remove('hidden');
        }

        // Simpan tab aktif
        localStorage.setItem('activeTabIndex', index);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const savedIndex = localStorage.getItem('activeTabIndex') || 0;
        highlightTab(savedIndex);
    });

    @foreach ($jenisLayanan as $index => $jenis)
        const kategoriLabels{{ $index }} = {!! json_encode($data[$jenis->jenis_layanan]['kategoriPeserta']->pluck('kategori')) !!};
        const kategoriData{{ $index }} = {!! json_encode($data[$jenis->jenis_layanan]['kategoriPeserta']->pluck('total')) !!};

        new Chart(document.getElementById('kategoriChart{{ $index }}').getContext('2d'), {
            type: 'pie',
            data: {
                labels: kategoriLabels{{ $index }},
                datasets: [{
                    data: kategoriData{{ $index }},
                    backgroundColor: {!! json_encode($chartColors) !!},
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        const topikLabels{{ $index }} = {!! json_encode($data[$jenis->jenis_layanan]['topikPopuler']->pluck('topik')) !!};
        const topikData{{ $index }} = {!! json_encode($data[$jenis->jenis_layanan]['topikPopuler']->pluck('total')) !!};

        new Chart(document.getElementById('topikChart{{ $index }}').getContext('2d'), {
            type: 'bar',
            data: {
                labels: topikLabels{{ $index }},
                datasets: [{
                    label: 'Jumlah Layanan',
                    data: topikData{{ $index }},
                    backgroundColor: '#34d399',
                    borderColor: '#059669',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    @endforeach
</script>

@endsection
