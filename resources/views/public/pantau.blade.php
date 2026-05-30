<x-guest-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center mb-4">Status Tiket</h2>

        <div class="text-center mb-4">
            <span class="px-3 py-1 rounded-full text-white text-sm 
                @if($tiket->status == 'open') bg-blue-600
                @elseif($tiket->status == 'in_progress') bg-yellow-500
                @elseif($tiket->status == 'resolved') bg-green-600
                @elseif($tiket->status == 'closed') bg-gray-500
                @endif">
                {{ ucfirst($tiket->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-2 text-sm mb-4">
            <div class="font-medium">Nama</div>
            <div>{{ $tiket->pelapor_nama }}</div>
            <div class="font-medium">Unit</div>
            <div>{{ $tiket->pelapor_unit }}</div>
            <div class="font-medium">Kategori</div>
            <div>{{ $tiket->kategori }}</div>
            <div class="font-medium">Prioritas</div>
            <div>{{ $tiket->prioritas }}</div>
            <div class="font-medium">Waktu Lapor</div>
            <div>{{ $tiket->created_at->format('d M Y H:i') }}</div>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold">Keluhan</h3>
            <p class="text-gray-700">{{ $tiket->keluhan }}</p>
        </div>

        @if($tiket->penyebab)
        <div class="mb-4">
            <h3 class="font-semibold">Penyebab</h3>
            <p>{{ $tiket->penyebab }}</p>
        </div>
        @endif

        @if($tiket->solusi)
        <div class="mb-4">
            <h3 class="font-semibold">Solusi</h3>
            <p>{{ $tiket->solusi }}</p>
        </div>
        @endif

        <div class="text-center text-sm text-gray-500">
            Kode Tiket: <span class="font-mono font-bold">{{ $tiket->kode_unik }}</span>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('lapor') }}" class="text-blue-600 underline">Buat Laporan Baru</a>
        </div>
    </div>
</x-guest-layout>