@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col w-full max-w-7xl">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-200 p-4 rounded-lg text-center shadow-md">Total Seminar</div>
        <div class="bg-gray-200 p-4 rounded-lg text-center shadow-md">Total Peserta</div>
        <div class="bg-gray-200 p-4 rounded-lg text-center shadow-md">Partisipasi</div>
        <div class="bg-gray-200 p-4 rounded-lg text-center shadow-md">Topik Populer</div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-gray-200 p-8 rounded-lg text-center shadow-md">
        Pie chart kategori peserta
      </div>
      <div class="bg-gray-200 p-8 rounded-lg text-center shadow-md">
        Bar chart jenis layanan
      </div>
    </div>
</div>
@endsection
