<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Tiket') }}
            </h2>
            <a href="{{ route('admin.tikets.index') }}" class="text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <!-- Header Tiket -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Tiket #{{ $tiket->kode_unik }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Dibuat {{ $tiket->created_at->format('d M Y, H:i') }} oleh {{ $tiket->pelapor_nama }} ({{ $tiket->pelapor_unit }})
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($tiket->status == 'open') bg-blue-100 text-blue-800
                                @elseif($tiket->status == 'in_progress') bg-yellow-100 text-yellow-800
                                @elseif($tiket->status == 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $tiket->status == 'in_progress' ? 'In Progress' : ucfirst($tiket->status) }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($tiket->prioritas == 'critical') bg-red-100 text-red-800
                                @elseif($tiket->prioritas == 'high') bg-orange-100 text-orange-800
                                @elseif($tiket->prioritas == 'medium') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($tiket->prioritas) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Body Tiket -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Utama -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Kategori</h4>
                            <p class="text-gray-900">{{ $tiket->kategori }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Teknisi</h4>
                            <p class="text-gray-900">{{ $tiket->teknisi?->name ?? 'Belum ditugaskan' }}</p>
                        </div>
                       <div>
                            <h4 class="text-sm font-medium text-gray-500">Deadline SLA</h4>
                            <p class="text-gray-900">{{ $tiket->sla_deadline ? $tiket->sla_deadline->format('d/m/Y H:i') : '-' }}</p>
                            @if($tiket->sla_deadline && $tiket->status != 'resolved' && $tiket->status != 'closed')
                                @if($tiket->sla_deadline->isPast())
                                    <p class="text-red-600 text-sm font-bold">⚠️ Terlewat {{ $tiket->sla_deadline->diffForHumans() }}</p>
                                @else
                                    <p class="text-green-600 text-sm">Sisa {{ $tiket->sla_deadline->diffForHumans() }}</p>
                                @endif
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Keluhan</h4>
                            <div class="mt-1 p-3 bg-gray-50 rounded-lg text-gray-900">
                                {{ $tiket->keluhan }}
                            </div>
                        </div>
                    </div>

                    <!-- Detail Teknis -->
                    <div class="space-y-4">
                        @if($tiket->penyebab)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Penyebab</h4>
                            <p class="text-gray-900">{{ $tiket->penyebab }}</p>
                        </div>
                        @endif
                        @if($tiket->solusi)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Solusi</h4>
                            <p class="text-gray-900">{{ $tiket->solusi }}</p>
                        </div>
                        @endif
                        @if($tiket->insiden)
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <h4 class="text-sm font-medium text-red-800">🚨 Terkait Insiden Siber</h4>
                            <p class="text-sm text-red-700">Jenis: {{ $tiket->insiden->jenis_serangan }} | Severity: {{ $tiket->insiden->severity }}</p>
                            <a href="{{ route('admin.insiden-siber.show', $tiket->insiden) }}" class="text-blue-600 text-sm hover:underline">Lihat Detail Insiden</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tombol Aksi Cepat -->
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Aksi Cepat</h4>
                    <div class="flex flex-wrap gap-2">
                        @if($tiket->status == 'open')
                            <form method="POST" action="{{ route('admin.tikets.update-status', $tiket) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                    ⚡ Ambil Tiket
                                </button>
                            </form>
                        @endif

                        @if($tiket->status == 'in_progress')
                            <form method="POST" action="{{ route('admin.tikets.update-status', $tiket) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                                    ✅ Tandai Resolved
                                </button>
                            </form>
                        @endif

                        @if($tiket->status == 'resolved')
                            <form method="POST" action="{{ route('admin.tikets.update-status', $tiket) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="closed">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                                    🔒 Tutup Tiket
                                </button>
                            </form>
                        @endif

                        @if($tiket->status == 'closed')
                            <form method="POST" action="{{ route('admin.tikets.update-status', $tiket) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="open">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                                    🔓 Buka Kembali
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.tikets.edit', $tiket) }}" class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition">
                            ✏️ Edit Tiket
                        </a>
                    </div>
                </div>

                <!-- Riwayat Status -->
                @if($tiket->riwayat->count() > 0)
                <div class="p-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Riwayat Perubahan Status</h4>
                    <ul class="space-y-2">
                        @foreach($tiket->riwayat as $riwayat)
                        <li class="flex items-center text-sm text-gray-600">
                            <span class="w-32 text-xs text-gray-400">{{ $riwayat->created_at->format('d/m/Y H:i') }}</span>
                            <span class="font-medium">{{ $riwayat->user?->name ?? 'System' }}</span>
                            <span class="mx-2">:</span>
                            <span class="px-2 py-0.5 rounded text-xs 
                                @if($riwayat->old_status == 'open') bg-blue-100 text-blue-800
                                @elseif($riwayat->old_status == 'in_progress') bg-yellow-100 text-yellow-800
                                @elseif($riwayat->old_status == 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $riwayat->old_status ?? 'None' }}
                            </span>
                            <span class="mx-1">→</span>
                            <span class="px-2 py-0.5 rounded text-xs 
                                @if($riwayat->new_status == 'open') bg-blue-100 text-blue-800
                                @elseif($riwayat->new_status == 'in_progress') bg-yellow-100 text-yellow-800
                                @elseif($riwayat->new_status == 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $riwayat->new_status }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>