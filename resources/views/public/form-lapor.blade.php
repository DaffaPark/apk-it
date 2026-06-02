<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 bg-gray-50" x-data="formLapor()">
        <div class="w-full max-w-5xl">
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-2xl overflow-hidden ring-1 ring-slate-100">
                {{-- Header --}}
                <div class="relative bg-gradient-to-r from-emerald-600 to-emerald-500 px-6 py-7 overflow-hidden">
                    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10"></div>
                    <div class="absolute -right-16 top-10 h-28 w-28 rounded-full bg-white/10"></div>
                    <div class="relative">
                        <div class="flex items-center justify-center gap-2">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/20 text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437"/></svg>
                            </span>
                            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">Lapor Kendala TI</h2>
                        </div>
                        <p class="text-emerald-50 text-sm text-center mt-2">Silakan isi form di bawah. Tim IT kami akan segera merespons.</p>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('lapor.submit') }}" class="p-6 md:p-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        {{-- Kolom Kiri --}}
                        <div class="space-y-5">
                            {{-- Nama --}}
                            <div>
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-800">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"/></svg>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="pelapor_nama" value="{{ old('pelapor_nama') }}" required
                                    class="mt-1.5 block w-full rounded-xl border-slate-300 text-slate-800 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40">
                                @error('pelapor_nama') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-800">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    Email <span class="font-normal text-slate-400">(opsional)</span>
                                </label>
                                <input type="email" name="pelapor_email" value="{{ old('pelapor_email') }}"
                                    class="mt-1.5 block w-full rounded-xl border-slate-300 text-slate-800 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40"
                                    placeholder="Untuk menerima notifikasi status">
                                @error('pelapor_email') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Unit (searchable dropdown) --}}
                            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-800">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                                    Unit / Bagian
                                </label>

                                {{-- Nilai asli yang dikirim ke server --}}
                                <input type="hidden" name="pelapor_unit" x-model="unit" required>

                                {{-- Kotak pencarian / pemicu dropdown --}}
                                <div class="relative mt-1.5">
                                    <input type="text" x-model="unitSearch" @focus="open = true" @input="open = true"
                                        autocomplete="off" placeholder="Cari atau pilih unit..."
                                        class="block w-full rounded-xl border-slate-300 text-slate-800 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40 pr-9">
                                    <button type="button" @click="open = !open"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                        <svg class="h-4 w-4 transition-transform" :class="open && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Daftar opsi --}}
                                <div x-show="open" x-transition
                                    class="absolute z-20 mt-1 w-full max-h-56 overflow-auto rounded-xl border border-slate-200 bg-white shadow-lg">
                                    <template x-for="u in filteredUnits" :key="u">
                                        <button type="button"
                                            @click="unit = u; unitSearch = u; open = false"
                                            class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-700"
                                            :class="unit === u && 'bg-emerald-50 text-emerald-700 font-medium'"
                                            x-text="u"></button>
                                    </template>
                                    <p x-show="filteredUnits.length === 0" class="px-4 py-2 text-sm text-slate-400">Unit tidak ditemukan</p>
                                </div>

                                @error('pelapor_unit') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="space-y-5">
                            {{-- Kategori --}}
                            <div>
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-800">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12.75V12a2.25 2.25 0 012.25-2.25h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/></svg>
                                    Kategori Masalah
                                </label>
                                <select x-model="kategori" name="kategori" required
                                    class="mt-1.5 block w-full rounded-xl border-slate-300 text-slate-800 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40">
                                    <option value="">-- Pilih Kategori --</option>
                                    <template x-for="kat in kategoris" :key="kat.value">
                                        <option :value="kat.value" x-text="kat.label"></option>
                                    </template>
                                </select>
                            </div>

                            {{-- Subkategori --}}
                            <div x-show="subkategoris.length > 0" x-transition>
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-800">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                                    Detail Masalah
                                </label>
                                <select x-model="subkategori" name="subkategori" required
                                    class="mt-1.5 block w-full rounded-xl border-slate-300 text-slate-800 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40">
                                    <option value="">-- Pilih Detail --</option>
                                    <template x-for="sub in subkategoris" :key="sub.value">
                                        <option :value="sub.value" x-text="sub.label"></option>
                                    </template>
                                </select>
                            </div>

                            {{-- Indikator Prioritas Otomatis (hanya info, bukan input) --}}
                            <div x-show="prioritas" x-transition class="mt-2">
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-800">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                    Prioritas Terdeteksi
                                </label>
                                <div class="mt-1.5 flex flex-wrap items-center gap-2">
                                    <span x-show="prioritas === 'critical'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-rose-100 text-rose-700 ring-1 ring-rose-200"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.047 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"/></svg>Critical (Ditangani &lt;1 jam)</span>
                                    <span x-show="prioritas === 'high'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-amber-100 text-amber-700 ring-1 ring-amber-200"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>High (Ditangani &lt;4 jam)</span>
                                    <span x-show="prioritas === 'medium'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 ring-1 ring-blue-200"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5"/></svg>Medium (Ditangani &lt;12 jam)</span>
                                    <span x-show="prioritas === 'low'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-slate-100 text-slate-600 ring-1 ring-slate-200"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Low (Ditangani &lt;24 jam)</span>
                                </div>
                            </div>

                            {{-- Hidden input prioritas (terisi otomatis oleh script) --}}
                            <input type="hidden" name="prioritas" x-model="prioritas">
                        </div>
                    </div>

                    {{-- Keluhan (Full Width) --}}
                    <div class="mt-5">
                        <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-800">
                            <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                            Deskripsi Keluhan
                        </label>
                        <textarea name="keluhan" rows="3" required
                            class="mt-1.5 block w-full rounded-xl border-slate-300 text-slate-800 shadow-sm transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/40"
                            placeholder="Ceritakan kendala yang dialami, kapan mulai terjadi, dan apa yang sudah dicoba...">{{ old('keluhan') }}</textarea>
                        @error('keluhan') <span class="text-rose-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="mt-7">
                        <button type="submit" class="group w-full inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-emerald-600/25 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:scale-[0.99] transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                            <span>Kirim Laporan</span>
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center text-xs text-slate-400 mt-4">Helpdesk TI &middot; Respons cepat sesuai prioritas</p>
        </div>
    </div>

    {{-- Script Alpine.js --}}
    <script>
        function formLapor() {
            return {
                kategori: '{{ old('kategori') }}',
                subkategori: '{{ old('subkategori') }}',
                prioritas: '{{ old('prioritas') }}',
                unit: '{{ old('pelapor_unit') }}',
                unitSearch: '{{ old('pelapor_unit') }}',

                units: [
                    'POLI MATA', 'AL BIRUNI', 'AL FARABI', 'AL HAITAM', 'AL RAZI',
                    'POLI UMUM', 'POLI PENYAKIT DALAM', 'POLI GIGI', 'FATIMAH AZAHRA', 'EDP',
                    'POLI UROLOGI', 'GIZI', 'HEMODIALISIS', 'FARMASI KLINIS', 'ICU - ICCU',
                    'IGD', 'INST FARMASI RAWAT INAP', 'INST FARMASI RAWAT JALAN', 'POLI BEDAH',
                    'LABORATORIUM', 'POLI FISIOTRAPI', 'POLI ORTHOPEDI', 'BEDAH / OK', 'VK BERSALIN',
                    'POLI KIA', 'RT/PERLENGKAPAN', 'POLI ANAK', 'PAVILIUN IBNU SINA', 'POLI THT',
                    'UPRS', 'LOGISTIK FARMASI', 'POLI JIWA', 'AL KINDI', 'POLI OBSGYN',
                    'KASIR RAWAT INAP', 'KASIR POLI', 'RADIOLOGI', 'PENDAFTARAN POLI', 'CASE MANAGER',
                    'POLI JANTUNG', 'POLI PARU', 'POLI REHAB MEDIK', 'POLI SARAF', 'POLI KULIT',
                    'PENDAFTARAN RAWAT INAP', 'POLI BEDAH TORAKS KARDIAK DAN VASKULAR', 'PEKARYA',
                    'LOUNDRY', 'CASEMIX', 'BIMROH', 'P3K', 'KABID KEPERAWATAN', 'KEUANGAN',
                    'Rekam Medis', 'PDP ANAK', 'PDP RINGAN NON-NEGATIF',
                    'ISOLASI NON TEKANAN NEGATIF, tanpa ventilator',
                    'ISOLASI TEKANAN NEGATIF, tanpa ventilator', 'ISOLASI',
                    'POLI GINJAL', 'POLI GIGI BEDAH MULUT'
                ],

                get filteredUnits() {
                    const q = (this.unitSearch || '').toLowerCase().trim();
                    if (!q) return this.units;
                    return this.units.filter(u => u.toLowerCase().includes(q));
                },

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
