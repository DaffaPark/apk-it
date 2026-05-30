<x-guest-layout>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center mb-6">Lapor Kendala TI</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('lapor.submit') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="pelapor_nama" :value="__('Nama Lengkap')" />
                <x-text-input id="pelapor_nama" type="text" name="pelapor_nama" required class="block w-full mt-1" />
                <x-input-error :messages="$errors->get('pelapor_nama')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="pelapor_unit" :value="__('Unit/Bagian')" />
                <x-text-input id="pelapor_unit" type="text" name="pelapor_unit" required class="block w-full mt-1" />
                <x-input-error :messages="$errors->get('pelapor_unit')" class="mt-2" />
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="kategori" :value="__('Kategori')" />
                    <select id="kategori" name="kategori" required class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="hardware">Hardware</option>
                        <option value="software">Software</option>
                        <option value="jaringan">Jaringan</option>
                        <option value="akun_password">Akun/Password</option>
                        <option value="simrs">SIMRS</option>
                        <option value="alat_medis">Alat Medis</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="prioritas" :value="__('Prioritas')" />
                    <select id="prioritas" name="prioritas" required class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <x-input-label for="keluhan" :value="__('Deskripsi Keluhan')" />
                <textarea id="keluhan" name="keluhan" rows="4" required class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jelaskan kendala yang dialami..."></textarea>
                <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
            </div>

            <div class="text-center">
                <x-primary-button>
                    Kirim Laporan
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>