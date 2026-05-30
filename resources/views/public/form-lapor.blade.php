<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 bg-gray-50" x-data="formLapor()">
        <div class="w-full max-w-5xl bg-white shadow-xl rounded-2xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white text-center">🛠️ Lapor Kendala TI</h2>
                <p class="text-indigo-100 text-sm text-center mt-1">Silakan isi form di bawah. Tim IT kami akan segera merespons.</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('lapor.submit') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-4">
                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">👤 Nama Lengkap</label>
                            <input type="text" name="pelapor_nama" value="{{ old('pelapor_nama') }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('pelapor_nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">📧 Email <span class="text-gray-400">(opsional)</span></label>
                            <input type="email" name="pelapor_email" value="{{ old('pelapor_email') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Untuk menerima notifikasi status">
                            @error('pelapor_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Unit --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">🏢 Unit / Bagian</label>
                            <input type="text" name="pelapor_unit" value="{{ old('pelapor_unit') }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('pelapor_unit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-4">
                        {{-- Kategori --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">📂 Kategori Masalah</label>
                            <select x-model="kategori" name="kategori" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Kategori --</option>
                                <template x-for="kat in kategoris" :key="kat.value">
                                    <option :value="kat.value" x-text="kat.label"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Subkategori --}}
                        <div x-show="subkategoris.length > 0">
                            <label class="block text-sm font-medium text-gray-700">🔍 Detail Masalah</label>
                            <select x-model="subkategori" name="subkategori" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Detail --</option>
                                <template x-for="sub in subkategoris" :key="sub.value">
                                    <option :value="sub.value" x-text="sub.label"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Indikator Prioritas Otomatis (hanya info, bukan input) --}}
                        <div x-show="prioritas" class="mt-2">
                            <label class="block text-sm font-medium text-gray-700">⚡ Prioritas Terdeteksi</label>
                            <div class="mt-1 flex items-center gap-2">
                                <span x-show="prioritas === 'critical'" class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">🔥 Critical (Ditangani &lt;1 jam)</span>
                                <span x-show="prioritas === 'high'" class="px-3 py-1 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">⚠️ High (Ditangani &lt;4 jam)</span>
                                <span x-show="prioritas === 'medium'" class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">📌 Medium (Ditangani &lt;12 jam)</span>
                                <span x-show="prioritas === 'low'" class="px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">✅ Low (Ditangani &lt;24 jam)</span>
                            </div>
                        </div>

                        {{-- Hidden input prioritas (terisi otomatis oleh script) --}}
                        <input type="hidden" name="prioritas" x-model="prioritas">
                    </div>
                </div>

                {{-- Keluhan (Full Width) --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">📝 Deskripsi Keluhan</label>
                    <textarea name="keluhan" rows="3" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Ceritakan kendala yang dialami, kapan mulai terjadi, dan apa yang sudah dicoba...">{{ old('keluhan') }}</textarea>
                    @error('keluhan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="mt-6 text-center">
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        🚀 Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Alpine.js --}}
    <script>
        function formLapor() {
            return {
                kategori: '{{ old('kategori') }}',
                subkategori: '{{ old('subkategori') }}',
                prioritas: '{{ old('prioritas') }}',

                kategoris: [
                    { value: 'hardware', label: '🖥️ Hardware (Perangkat Keras)' },
                    { value: 'software', label: '💿 Software (Aplikasi)' },
                    { value: 'jaringan', label: '🌐 Jaringan / Internet' },
                    { value: 'akun_password', label: '🔑 Akun / Password' },
                    { value: 'lainnya', label: '📦 Lainnya' }
                ],

                subkategoriData: {
                    hardware: [
                        { value: 'pc', label: '💻 PC / Laptop (Krusial)', prioritas: 'critical' },
                        { value: 'printer', label: '🖨️ Printer', prioritas: 'high' },
                        { value: 'monitor', label: '🖥️ Monitor', prioritas: 'medium' },
                        { value: 'server', label: '🗄️ Server (Krusial)', prioritas: 'critical' },
                        { value: 'jaringan_perangkat', label: '📶 Router / Switch', prioritas: 'high' },
                        { value: 'lainnya_hardware', label: '🔌 Lainnya', prioritas: 'low' }
                    ],
                    software: [
                        { value: 'simrs', label: '🏥 SIMRS (Krusial)', prioritas: 'critical' },
                        { value: 'office', label: '📝 Microsoft Office', prioritas: 'medium' },
                        { value: 'email', label: '📧 Email', prioritas: 'medium' },
                        { value: 'browser', label: '🌍 Browser', prioritas: 'low' },
                        { value: 'aplikasi_khusus', label: '📱 Aplikasi Khusus', prioritas: 'high' },
                        { value: 'lainnya_software', label: '📦 Lainnya', prioritas: 'low' }
                    ],
                    jaringan: [
                        { value: 'wifi', label: '📶 WiFi', prioritas: 'high' },
                        { value: 'lan', label: '🔌 LAN (Kabel)', prioritas: 'high' },
                        { value: 'internet_mati', label: '❌ Internet Mati (Krusial)', prioritas: 'critical' },
                        { value: 'akses_aplikasi', label: '🚫 Akses Aplikasi', prioritas: 'critical' },
                        { value: 'lainnya_jaringan', label: '📦 Lainnya', prioritas: 'medium' }
                    ],
                    akun_password: [
                        { value: 'lupa_password', label: '🔒 Lupa Password', prioritas: 'medium' },
                        { value: 'akun_terkunci', label: '🔐 Akun Terkunci', prioritas: 'medium' },
                        { value: 'buat_akun', label: '🆕 Buat Akun Baru', prioritas: 'low' },
                        { value: 'hak_akses', label: '🛡️ Hak Akses', prioritas: 'medium' },
                        { value: 'lainnya_akun', label: '📦 Lainnya', prioritas: 'low' }
                    ],
                    lainnya: [
                        { value: 'permintaan_data', label: '📊 Permintaan Data', prioritas: 'low' },
                        { value: 'konsultasi', label: '💬 Konsultasi', prioritas: 'low' },
                        { value: 'instalasi', label: '⚙️ Instalasi', prioritas: 'medium' },
                        { value: 'pemeliharaan', label: '🔧 Pemeliharaan', prioritas: 'medium' },
                        { value: 'lainnya_lainnya', label: '📦 Lainnya', prioritas: 'low' }
                    ]
                },

                get subkategoris() {
                    return this.kategori ? (this.subkategoriData[this.kategori] || []) : [];
                },

                init() {
                    this.$watch('subkategori', value => {
                        if (value) {
                            const selected = this.subkategoris.find(s => s.value === value);
                            if (selected) this.prioritas = selected.prioritas;
                        }
                    });
                    if (this.kategori) {
                        this.$nextTick(() => {
                            if (this.subkategori) {
                                const selected = this.subkategoris.find(s => s.value === this.subkategori);
                                if (selected) this.prioritas = selected.prioritas;
                            }
                        });
                    }
                }
            }
        }
    </script>
</x-guest-layout>