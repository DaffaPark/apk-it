<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dokumen & Notulen') }}
            </h2>
            <a href="{{ route('admin.dokumen.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Upload Dokumen
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Search & Filter -->
            <form method="GET" class="mb-4 flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, tag, versi..." 
                    class="flex-1 rounded border-gray-300 shadow-sm">
                <select name="status" class="rounded border-gray-300">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="arsip" {{ request('status') == 'arsip' ? 'selected' : '' }}>Arsip</option>
                </select>
                <button type="submit" class="bg-gray-200 px-4 py-2 rounded">Filter</button>
            </form>

            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Versi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diunggah Oleh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($dokumens as $dok)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium">{{ $dok->judul }}</td>
                            <td class="px-6 py-4 text-sm">{{ $dok->kategori_tag ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $dok->versi }}</td>
                            <td class="px-6 py-4 text-sm">{{ $dok->status }}</td>
                            <td class="px-6 py-4 text-sm">{{ $dok->uploader?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm flex gap-2">
                                <a href="{{ route('admin.dokumen.download', $dok) }}" class="text-green-600 hover:underline">Download</a>
                                <a href="{{ route('admin.dokumen.edit', $dok) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.dokumen.destroy', $dok) }}" onsubmit="return confirm('Hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $dokumens->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>