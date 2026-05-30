<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Tiket Open/Progress</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $totalOpen }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Resolved</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $totalResolved }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Closed</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $totalClosed }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal Mendatang -->
            @if(isset($jadwalMendatang) && $jadwalMendatang->count() > 0)
            <div class="bg-white overflow-hidden shadow rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Jadwal Pemeliharaan Mendatang</h3>
                <ul class="space-y-2">
                    @foreach($jadwalMendatang as $jadwal)
                    <li class="flex justify-between text-sm">
                        <span>{{ $jadwal->nama }}</span>
                        <span class="text-gray-500">{{ $jadwal->tanggal_mulai->format('d/m/Y') }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($overdue > 0)
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                ⚠️ {{ $overdue }} tiket melewati SLA deadline! <a href="{{ route('admin.tikets.index', ['status' => 'open']) }}" class="underline">Lihat</a>
            </div>
            @endif

            <!-- Tabel Tiket Terbaru -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tiket Terbaru</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tiketsTerbaru as $tiket)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->kode_unik }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->pelapor_nama }}</td>
                                <td class="px-6 py-4 text-sm">{{ Str::limit($tiket->keluhan, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->prioritas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $tiket->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>