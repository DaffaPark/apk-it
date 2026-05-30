<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Aktivitas Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Filter -->
            <form method="GET" class="mb-4 bg-white p-4 rounded-lg shadow flex flex-wrap gap-4">
                <select name="user_id" class="rounded border-gray-300">
                    <option value="">Semua User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <select name="aksi" class="rounded border-gray-300">
                    <option value="">Semua Aksi</option>
                    <option value="CREATE" {{ request('aksi') == 'CREATE' ? 'selected' : '' }}>CREATE</option>
                    <option value="UPDATE" {{ request('aksi') == 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                    <option value="DELETE" {{ request('aksi') == 'DELETE' ? 'selected' : '' }}>DELETE</option>
                </select>
                <select name="nama_tabel" class="rounded border-gray-300">
                    <option value="">Semua Tabel</option>
                    @foreach($tables as $table)
                        <option value="{{ $table }}" {{ request('nama_tabel') == $table ? 'selected' : '' }}>
                            {{ $table }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="rounded border-gray-300">
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="rounded border-gray-300">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                <a href="{{ route('admin.log-aktivitas.index') }}" class="bg-gray-200 px-4 py-2 rounded">Reset</a>
            </form>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tabel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Record ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($logs as $log)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $log->user?->name ?? 'System' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($log->aksi == 'CREATE') bg-green-100 text-green-800
                                    @elseif($log->aksi == 'UPDATE') bg-yellow-100 text-yellow-800
                                    @elseif($log->aksi == 'DELETE') bg-red-100 text-red-800
                                    @endif">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $log->nama_tabel }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $log->record_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $log->ip_address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.log-aktivitas.show', $log) }}" class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>