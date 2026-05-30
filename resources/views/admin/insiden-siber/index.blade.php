<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Insiden Siber') }}
            </h2>
            <a href="{{ route('admin.insiden-siber.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Catat Insiden
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Filter -->
            <form method="GET" class="mb-4 bg-white p-4 rounded-lg shadow flex flex-wrap gap-4">
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="rounded border-gray-300">
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="rounded border-gray-300">
                <select name="severity" class="rounded border-gray-300">
                    <option value="">Semua Severity</option>
                    <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
                <select name="status" class="rounded border-gray-300">
                    <option value="">Semua Status</option>
                    <option value="terdeteksi" {{ request('status') == 'terdeteksi' ? 'selected' : '' }}>Terdeteksi</option>
                    <option value="dalam_penanganan" {{ request('status') == 'dalam_penanganan' ? 'selected' : '' }}>Dalam Penanganan</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="false_positive" {{ request('status') == 'false_positive' ? 'selected' : '' }}>False Positive</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            </form>

            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Serangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sumber IP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Severity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdeteksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($insidens as $insiden)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $insiden->jenis_serangan }}</td>
                            <td class="px-6 py-4 text-sm">{{ $insiden->sumber_ip ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($insiden->severity == 'critical') bg-red-100 text-red-800
                                    @elseif($insiden->severity == 'high') bg-orange-100 text-orange-800
                                    @elseif($insiden->severity == 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $insiden->severity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $insiden->status }}</td>
                            <td class="px-6 py-4 text-sm">{{ $insiden->tiket?->kode_unik ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $insiden->detected_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm flex gap-2">
                                <a href="{{ route('admin.insiden-siber.show', $insiden) }}" class="text-blue-600 hover:underline">Detail</a>
                                <a href="{{ route('admin.insiden-siber.edit', $insiden) }}" class="text-yellow-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $insidens->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>