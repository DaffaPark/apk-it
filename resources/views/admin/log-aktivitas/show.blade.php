<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Log Aktivitas') }}
            </h2>
            <a href="{{ route('admin.log-aktivitas.index') }}" class="text-blue-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div><span class="text-gray-500">Waktu:</span> <span class="font-medium">{{ $logAktivitas->created_at->format('d/m/Y H:i:s') }}</span></div>
                    <div><span class="text-gray-500">User:</span> <span class="font-medium">{{ $logAktivitas->user?->name ?? 'System' }}</span></div>
                    <div><span class="text-gray-500">Aksi:</span> <span class="font-medium">{{ $logAktivitas->aksi }}</span></div>
                    <div><span class="text-gray-500">Tabel:</span> <span class="font-medium">{{ $logAktivitas->nama_tabel }}</span></div>
                    <div><span class="text-gray-500">Record ID:</span> <span class="font-medium">{{ $logAktivitas->record_id }}</span></div>
                    <div><span class="text-gray-500">IP Address:</span> <span class="font-medium">{{ $logAktivitas->ip_address }}</span></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold mb-2 text-red-600">Data Lama</h3>
                        <pre class="bg-gray-100 p-4 rounded overflow-auto text-sm">{{ json_encode($logAktivitas->data_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2 text-green-600">Data Baru</h3>
                        <pre class="bg-gray-100 p-4 rounded overflow-auto text-sm">{{ json_encode($logAktivitas->data_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>