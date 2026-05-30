<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kanban Board') }}
            </h2>
            <button onclick="document.getElementById('addTaskModal').classList.toggle('hidden')" 
                    class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                + Tambah Tugas
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Statistik Mini -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4 border-t-4 border-blue-500">
                    <div class="text-gray-500 text-sm">To Do</div>
                    <div class="text-2xl font-bold">{{ $totalToDo }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 border-t-4 border-yellow-500">
                    <div class="text-gray-500 text-sm">In Progress</div>
                    <div class="text-2xl font-bold">{{ $totalInProgress }}</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 border-t-4 border-green-500">
                    <div class="text-gray-500 text-sm">Done</div>
                    <div class="text-2xl font-bold">{{ $totalDone }}</div>
                </div>
            </div>

            <!-- Board 3 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="kanban-board">
                @foreach(['to_do' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $status => $label)
                <div class="bg-gray-100 rounded-lg p-4">
                    <h3 class="font-semibold text-lg mb-3 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full 
                            @if($status == 'to_do') bg-blue-500 
                            @elseif($status == 'in_progress') bg-yellow-500 
                            @else bg-green-500 @endif">
                        </span>
                        {{ $label }}
                        <span class="text-sm text-gray-500 font-normal">
                            ({{ $pekerjaans->get($status, collect())->count() }})
                        </span>
                    </h3>

                    <div class="space-y-3 kanban-column" data-status="{{ $status }}">
                        @foreach($pekerjaans->get($status, collect()) as $pekerjaan)
                        <div class="bg-white rounded-lg shadow p-4 cursor-move kanban-card" 
                             data-id="{{ $pekerjaan->id }}"
                             draggable="true">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-medium text-sm">{{ $pekerjaan->judul }}</h4>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($pekerjaan->prioritas == 'critical') bg-red-100 text-red-800
                                    @elseif($pekerjaan->prioritas == 'high') bg-orange-100 text-orange-800
                                    @elseif($pekerjaan->prioritas == 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $pekerjaan->prioritas ?? '-' }}
                                </span>
                            </div>
                            @if($pekerjaan->deskripsi)
                                <p class="text-xs text-gray-500 mb-2">{{ Str::limit($pekerjaan->deskripsi, 80) }}</p>
                            @endif
                            <div class="flex justify-between items-center text-xs text-gray-400">
                                <span>
                                    @if($pekerjaan->assignee)
                                        👤 {{ $pekerjaan->assignee->name }}
                                    @else
                                        👤 Belum di-assign
                                    @endif
                                </span>
                                @if($pekerjaan->deadline)
                                    <span>📅 {{ $pekerjaan->deadline->format('d/m') }}</span>
                                @endif
                            </div>
                            @if($pekerjaan->tiket)
                                <div class="mt-2 text-xs text-blue-600">
                                    🔗 <a href="{{ route('admin.tikets.show', $pekerjaan->tiket) }}">Tiket #{{ $pekerjaan->tiket->kode_unik }}</a>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Tambah Tugas -->
    <div id="addTaskModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-black opacity-50" onclick="document.getElementById('addTaskModal').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-lg shadow-xl p-6 w-full max-w-md z-10">
                <h3 class="text-lg font-semibold mb-4">Tambah Tugas Baru</h3>
                <form method="POST" action="{{ route('admin.pekerjaan.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Judul Tugas</label>
                            <input type="text" name="judul" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Deskripsi</label>
                            <textarea name="deskripsi" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium">Prioritas</label>
                                <select name="prioritas" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Assign Ke</label>
                                <select name="assignee_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">-- Pilih --</option>
                                    @foreach($teknisis as $teknisi)
                                        <option value="{{ $teknisi->id }}">{{ $teknisi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Deadline</label>
                            <input type="date" name="deadline" class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('addTaskModal').classList.add('hidden')" 
                                class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SortableJS untuk Drag & Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const columns = document.querySelectorAll('.kanban-column');
            
            columns.forEach(column => {
                new Sortable(column, {
                    group: 'kanban',
                    animation: 150,
                    ghostClass: 'bg-gray-200',
                    onEnd: function(evt) {
                        const cardId = evt.item.dataset.id;
                        const newStatus = evt.to.dataset.status;
                        
                        fetch(`/admin/pekerjaan/${cardId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Refresh halaman atau update counter
                                location.reload();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
    </script>
</x-app-layout>