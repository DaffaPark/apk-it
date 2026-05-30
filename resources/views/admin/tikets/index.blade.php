<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiket Keluhan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Tiket</h3>
                        <a href="{{ route('admin.tikets.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Buat Tiket</a>
                    </div>

                    <!-- Filter -->
                    <form method="GET" class="mb-4 flex gap-4">
                        <select name="status" class="rounded border-gray-300">
                            <option value="">Semua Status</option>
                            <option value="open" {{ request('status')=='open'?'selected':'' }}>Open</option>
                            <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>In Progress</option>
                            <option value="resolved" {{ request('status')=='resolved'?'selected':'' }}>Resolved</option>
                            <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
                        </select>
                        <select name="prioritas" class="rounded border-gray-300">
                            <option value="">Semua Prioritas</option>
                            <option value="low" {{ request('prioritas')=='low'?'selected':'' }}>Low</option>
                            <option value="medium" {{ request('prioritas')=='medium'?'selected':'' }}>Medium</option>
                            <option value="high" {{ request('prioritas')=='high'?'selected':'' }}>High</option>
                            <option value="critical" {{ request('prioritas')=='critical'?'selected':'' }}>Critical</option>
                        </select>
                        <button type="submit" class="bg-gray-200 px-4 py-2 rounded">Filter</button>
                    </form>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teknisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tikets as $tiket)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->kode_unik }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->pelapor_nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->pelapor_unit }}</td>
                                <td class="px-6 py-4 text-sm">{{ Str::limit($tiket->keluhan, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->prioritas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->teknisi?->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.tikets.show', $tiket) }}" class="text-blue-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $tikets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>