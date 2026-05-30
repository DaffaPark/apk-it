<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventaris Perangkat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold">Daftar Perangkat</h3>
                    <a href="{{ route('admin.inventaris.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</a>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode QR</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kondisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($inventaris as $item)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $item->kode_qr }}</td>
                            <td class="px-6 py-4 text-sm">{{ $item->nama_perangkat }}</td>
                            <td class="px-6 py-4 text-sm">{{ $item->kategori }}</td>
                            <td class="px-6 py-4 text-sm">{{ $item->status_kondisi }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.inventaris.show', $item) }}" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $inventaris->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>