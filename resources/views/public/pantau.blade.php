<x-guest-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow">
        {{-- Judul --}}
        <h2 class="text-2xl font-bold text-center mb-2">Status Tiket</h2>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Status Tiket --}}
        <div class="text-center mb-6">
            <span class="px-4 py-2 rounded-full text-white text-sm font-semibold 
                @if($tiket->status == 'open') bg-blue-600
                @elseif($tiket->status == 'in_progress') bg-yellow-500
                @elseif($tiket->status == 'resolved') bg-green-600
                @elseif($tiket->status == 'closed') bg-gray-500
                @endif">
                {{ $tiket->status == 'in_progress' ? 'In Progress' : ucfirst($tiket->status) }}
            </span>
        </div>

        {{-- Informasi Tiket --}}
        <div class="grid grid-cols-2 gap-3 text-sm mb-6">
            <div class="font-medium text-gray-600">Nama</div>
            <div>{{ $tiket->pelapor_nama }}</div>

            <div class="font-medium text-gray-600">Unit</div>
            <div>{{ $tiket->pelapor_unit }}</div>

            <div class="font-medium text-gray-600">Kategori</div>
            <div>{{ $tiket->kategori }}</div>

            <div class="font-medium text-gray-600">Prioritas</div>
            <div>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                    @if($tiket->prioritas == 'critical') bg-red-100 text-red-800
                    @elseif($tiket->prioritas == 'high') bg-orange-100 text-orange-800
                    @elseif($tiket->prioritas == 'medium') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($tiket->prioritas) }}
                </span>
            </div>

            <div class="font-medium text-gray-600">Waktu Lapor</div>
            <div>{{ $tiket->created_at->format('d M Y, H:i') }}</div>

            @if($tiket->resolved_at)
                <div class="font-medium text-gray-600">Waktu Selesai</div>
                <div>{{ $tiket->resolved_at->format('d M Y, H:i') }}</div>
            @endif
        </div>

        {{-- Teknisi yang Menangani --}}
        @if($tiket->teknisi)
        <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
            <p class="text-sm font-medium text-blue-800">
                👨‍🔧 Ditangani oleh: <span class="font-bold">{{ $tiket->teknisi->name }}</span>
            </p>
        </div>
        @endif

        {{-- Keluhan --}}
        <div class="mb-4 mt-4">
            <h3 class="font-semibold text-gray-700">Keluhan</h3>
            <div class="p-3 bg-gray-50 rounded mt-1 text-gray-800">
                {{ $tiket->keluhan }}
            </div>
        </div>

        {{-- Penyebab --}}
        @if($tiket->penyebab)
        <div class="mb-4">
            <h3 class="font-semibold text-gray-700">Penyebab</h3>
            <p class="text-gray-800">{{ $tiket->penyebab }}</p>
        </div>
        @endif

        {{-- Solusi --}}
        @if($tiket->solusi)
        <div class="mb-4">
            <h3 class="font-semibold text-gray-700">Solusi</h3>
            <p class="text-gray-800">{{ $tiket->solusi }}</p>
        </div>
        @endif

        {{-- Timeline Riwayat Status --}}
        @if($tiket->riwayat && $tiket->riwayat->count() > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-700 mb-3">Riwayat Status</h3>
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @foreach($tiket->riwayat->sortByDesc('created_at') as $riwayat)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                        @if($riwayat->new_status == 'open') bg-blue-500
                                        @elseif($riwayat->new_status == 'in_progress') bg-yellow-500
                                        @elseif($riwayat->new_status == 'resolved') bg-green-500
                                        @else bg-gray-500 @endif">
                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium text-gray-900">{{ $riwayat->created_at->format('d/m/Y H:i') }}</span>
                                        – Status diubah menjadi 
                                        <span class="font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $riwayat->new_status)) }}</span>
                                    </p>
                                    @if($riwayat->catatan)
                                        <p class="text-xs text-gray-500">{{ $riwayat->catatan }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- Komentar & Bukti Penanganan --}}
        <div class="mt-6">
            <h3 class="font-semibold text-gray-700">💬 Komentar & Bukti Penanganan</h3>
            
            <div class="space-y-4 mt-3">
                @forelse($tiket->komentars as $komentar)
                    <div class="bg-gray-50 rounded-lg p-4 {{ $komentar->user_id ? 'border-l-4 border-indigo-400' : 'border-l-4 border-green-400' }}">
                        <div class="flex justify-between items-start">
                            <span class="font-medium text-sm">
                                {{ $komentar->user?->name ?? 'Anda' }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $komentar->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-800 mt-1">{{ $komentar->pesan }}</p>
                        @if($komentar->lampiran_url)
                            <div class="mt-2">
                                <a href="{{ Storage::url($komentar->lampiran_url) }}" target="_blank" 
                                   class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                    📎 Lihat Bukti
                                </a>
                                @if(in_array(pathinfo($komentar->lampiran_url, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif']))
                                    <img src="{{ Storage::url($komentar->lampiran_url) }}" class="mt-2 max-w-xs rounded shadow" alt="Bukti">
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada komentar dari teknisi.</p>
                @endforelse
            </div>

            {{-- Form Balasan untuk Pelapor --}}
            <form method="POST" action="{{ route('pantau.komentar.store', $tiket->kode_unik) }}" class="mt-4 bg-white rounded-lg p-4 border">
                @csrf
                <textarea name="pesan" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm" 
                          placeholder="Tanyakan sesuatu atau beri balasan..."></textarea>
                <div class="flex justify-end mt-2">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>

        {{-- Form Feedback --}}
        @if($tiket->status == 'resolved' && !$tiket->feedback_rating)
        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
            <h3 class="font-semibold text-gray-700">Beri Feedback</h3>
            <form method="POST" action="{{ route('feedback.submit', $tiket) }}">
                @csrf
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <select name="rating" class="block w-full mt-1 rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Pilih Rating --</option>
                        <option value="5">★★★★★ (Sangat Baik)</option>
                        <option value="4">★★★★☆ (Baik)</option>
                        <option value="3">★★★☆☆ (Cukup)</option>
                        <option value="2">★★☆☆☆ (Buruk)</option>
                        <option value="1">★☆☆☆☆ (Sangat Buruk)</option>
                    </select>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-gray-700">Komentar (opsional)</label>
                    <textarea name="komentar" rows="2" class="block w-full mt-1 rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis komentar Anda..."></textarea>
                </div>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Kirim Feedback
                </button>
            </form>
        </div>
        @endif

        {{-- Feedback yang sudah diberikan --}}
        @if($tiket->feedback_rating)
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded">
            <h3 class="font-semibold text-gray-700">Feedback Anda</h3>
            <p class="text-sm mt-1">Rating: 
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $tiket->feedback_rating)
                        ★
                    @else
                        ☆
                    @endif
                @endfor
                ({{ $tiket->feedback_rating }}/5)
            </p>
            @if($tiket->feedback_catatan)
                <p class="text-sm text-gray-600 mt-1">{{ $tiket->feedback_catatan }}</p>
            @endif
        </div>
        @endif

        {{-- Kode Tiket & Navigasi --}}
        <div class="text-center text-sm text-gray-500 mt-6">
            Kode Tiket: <span class="font-mono font-bold text-gray-800">{{ $tiket->kode_unik }}</span>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('lapor') }}" class="text-blue-600 hover:underline">Buat Laporan Baru</a>
        </div>
    </div>
</x-guest-layout>