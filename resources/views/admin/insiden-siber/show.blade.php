<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detail Insiden') }}</h2>
            <a href="{{ route('admin.insiden-siber.index') }}" class="text-blue-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div><span class="text-gray-500">Jenis:</span> <strong>{{ $insidenSiber->jenis_serangan }}</strong></div>
                    <div><span class="text-gray-500">IP:</span> {{ $insidenSiber->sumber_ip ?? '-' }}</div>
                    <div><span class="text-gray-500">Severity:</span> <strong>{{ $insidenSiber->severity }}</strong></div>
                    <div><span class="text-gray-500">Status:</span> {{ $insidenSiber->status }}</div>
                    <div><span class="text-gray-500">Tiket:</span> {{ $insidenSiber->tiket?->kode_unik ?? '-' }}</div>
                    <div><span class="text-gray-500">Terdeteksi:</span> {{ $insidenSiber->detected_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="mt-4"><span class="text-gray-500">Detail:</span><br>{{ $insidenSiber->detail ?? '-' }}</div>

                <div class="mt-6">
                    <h3 class="font-semibold">Log Perubahan</h3>
                    <ul class="list-disc pl-5 mt-2">
                        @foreach($insidenSiber->logs as $log)
                            <li class="text-sm">{{ $log->created_at->format('d/m/Y H:i') }} — {{ $log->aksi }} ({{ $log->user?->name ?? 'System' }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>