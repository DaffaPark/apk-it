<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jadwal Pemeliharaan') }}
            </h2>
            <a href="{{ route('admin.jadwal-pemeliharaan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Jadwal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mulai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perangkat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aktif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($jadwals as $jadwal)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $jadwal->nama }}</td>
                            <td class="px-6 py-4 text-sm">{{ ucfirst($jadwal->jenis) }}</td>
                            <td class="px-6 py-4 text-sm">{{ $jadwal->tanggal_mulai->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $jadwal->inventaris?->nama_perangkat ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $jadwal->is_active ? '✅' : '❌' }}</td>
                            <td class="px-6 py-4 text-sm flex gap-2">
                                <a href="{{ route('admin.jadwal-pemeliharaan.edit', $jadwal) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.jadwal-pemeliharaan.destroy', $jadwal) }}" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $jadwals->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>