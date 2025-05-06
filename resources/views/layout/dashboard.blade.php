@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col w-full max-w-7xl">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-pink-200 p-4 rounded-lg text-center shadow-md">
            <div class="text-xl font-bold">{{ $totalSeminar }}</div>
            <div>Total Layanan</div>
        </div>
        <div class="bg-purple-200 p-4 rounded-lg text-center shadow-md">
            <div class="text-xl font-bold">{{ $totalPeserta }}</div>
            <div>Total Peserta</div>
        </div>
        <div class="bg-yellow-200 p-4 rounded-lg text-center shadow-md">
            <div class="text-xl font-bold">{{ $totalPartisipasi }}</div>
            <div>Partisipasi</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-300 p-8 rounded-lg text-center shadow-md">
            <h2 class="text-lg font-semibold text-center mb-5">Kategori Peserta</h2>
            <canvas id="kategoriChart" class="w-full max-w-sm h-64 mx-auto" ></canvas>
        </div>
        <div class="bg-gray-300 p-8 rounded-lg text-center shadow-md">
            <h2 class="text-lg font-semibold text-center mb-10">Topik Populer (Jumlah Layanan)</h2>
            <canvas id="topikChart" class="w-full h-64 mx-auto"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kategoriLabels = {!! json_encode($kategoriPeserta->pluck('kategori')) !!};
    const kategoriData = {!! json_encode($kategoriPeserta->pluck('total')) !!};

    const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctxKategori, {
        type: 'pie',
        data: {
            labels: kategoriLabels,
            datasets: [{
                data: kategoriData,
                backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa', '#f472b6'],
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    const topikLabels = {!! json_encode($topikPopuler->pluck('topik')) !!};
    const topikData = {!! json_encode($topikPopuler->pluck('total')) !!};

    const ctxTopik = document.getElementById('topikChart').getContext('2d');
    new Chart(ctxTopik, {
        type: 'bar',
        data: {
            labels: topikLabels,
            datasets: [{
                label: 'Jumlah Layanan',
                data: topikData,
                backgroundColor: '#34d399',
                borderColor: '#059669',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection

