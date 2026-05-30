<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div><strong>Kode:</strong> {{ $tiket->kode_unik }}</div>
                    <div><strong>Status:</strong>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $tiket->status == 'open' ? 'blue' : ($tiket->status == 'in_progress' ? 'yellow' : ($tiket->status == 'resolved' ? 'green' : 'gray')) }}-100 text-{{ $tiket->status == 'open' ? 'blue' : ($tiket->status == 'in_progress' ? 'yellow' : ($tiket->status == 'resolved' ? 'green' : 'gray')) }}-800">
                            {{ $tiket->status }}
                        </span>
                    </div>
                    <div><strong>Nama Pelapor:</strong> {{ $tiket->pelapor_nama }}</div>
                    <div><strong>Unit:</strong> {{ $tiket->pelapor_unit }}</div>
                    <div><strong>Kategori:</strong> {{ $tiket->kategori }}</div>
                    <div><strong>Prioritas:</strong> {{ $tiket->prioritas }}</div>
                    <div><strong>Teknisi:</strong> {{ $tiket->teknisi?->name ?? 'Belum ditugaskan' }}</div>
                    <div><strong>Waktu Lapor:</strong> {{ $tiket->created_at->format('d/m/Y H:i') }}</div>
                    <div><strong>Deadline SLA:</strong> {{ $tiket->sla_deadline ? $tiket->sla_deadline->format('d/m/Y H:i') : '-' }}</div>
                </div>

                <div class="mt-4">
                    <h3 class="font-semibold">Keluhan</h3>
                    <p class="text-gray-700">{{ $tiket->keluhan }}</p>
                </div>

                @if($tiket->penyebab)
                <div class="mt-4">
                    <h3 class="font-semibold">Penyebab</h3>
                    <p>{{ $tiket->penyebab }}</p>
                </div>
                @endif

                @if($tiket->solusi)
                <div class="mt-4">
                    <h3 class="font-semibold">Solusi</h3>
                    <p>{{ $tiket->solusi }}</p>
                </div>
                @endif

                <!-- Update Status -->
                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Ubah Status</h3>
                    <form method="POST" action="{{ route('admin.tikets.update-status', $tiket) }}" class="flex gap-4">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="rounded border-gray-300">
                            <option value="open" {{ $tiket->status=='open'?'selected':'' }}>Open</option>
                            <option value="in_progress" {{ $tiket->status=='in_progress'?'selected':'' }}>In Progress</option>
                            <option value="resolved" {{ $tiket->status=='resolved'?'selected':'' }}>Resolved</option>
                            <option value="closed" {{ $tiket->status=='closed'?'selected':'' }}>Closed</option>
                        </select>
                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded">Update Status</button>
                    </form>
                </div>

                <!-- Riwayat -->
                <div class="mt-6">
                    <h3 class="font-semibold">Riwayat Status</h3>
                    <ul class="list-disc pl-5">
                        @foreach($tiket->riwayat as $riwayat)
                        <li>
                            {{ $riwayat->created_at->format('d/m/Y H:i') }} -
                            <strong>{{ $riwayat->old_status ?? 'None' }}</strong> → <strong>{{ $riwayat->new_status }}</strong>
                            oleh {{ $riwayat->user?->name ?? 'System' }}
                            @if($riwayat->catatan) ({{ $riwayat->catatan }}) @endif
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.tikets.edit', $tiket) }}" class="text-blue-600 hover:underline">Edit Tiket</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>