<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="pelapor_nama" :value="__('Nama Pelapor')" />
            <x-text-input id="pelapor_nama" type="text" name="pelapor_nama" :value="old('pelapor_nama', $tiket->pelapor_nama ?? '')" required class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('pelapor_nama')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="pelapor_unit" :value="__('Unit Pelapor')" />
            <x-text-input id="pelapor_unit" type="text" name="pelapor_unit" :value="old('pelapor_unit', $tiket->pelapor_unit ?? '')" required class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('pelapor_unit')" class="mt-2" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <x-input-label for="kategori" :value="__('Kategori')" />
            <select id="kategori" name="kategori" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach(['hardware','software','jaringan','akun_password','simrs','alat_medis','lainnya'] as $kat)
                <option value="{{ $kat }}" {{ old('kategori', $tiket->kategori ?? '') == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="prioritas" :value="__('Prioritas')" />
            <select id="prioritas" name="prioritas" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach(['low','medium','high','critical'] as $pr)
                <option value="{{ $pr }}" {{ old('prioritas', $tiket->prioritas ?? '') == $pr ? 'selected' : '' }}>{{ ucfirst($pr) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="teknisi_id" :value="__('Assign Teknisi')" />
            <select id="teknisi_id" name="teknisi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Teknisi --</option>
                @foreach($teknisis as $teknisi)
                <option value="{{ $teknisi->id }}" {{ old('teknisi_id', $tiket->teknisi_id ?? '') == $teknisi->id ? 'selected' : '' }}>{{ $teknisi->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <x-input-label for="keluhan" :value="__('Deskripsi Keluhan')" />
        <textarea id="keluhan" name="keluhan" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('keluhan', $tiket->keluhan ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
    </div>

    @if(isset($tiket) && $tiket->exists)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="penyebab" :value="__('Penyebab')" />
            <textarea id="penyebab" name="penyebab" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('penyebab', $tiket->penyebab ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="solusi" :value="__('Solusi')" />
            <textarea id="solusi" name="solusi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('solusi', $tiket->solusi ?? '') }}</textarea>
        </div>
    </div>
    @endif
</div>