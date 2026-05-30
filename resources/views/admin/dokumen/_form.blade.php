<div class="space-y-4">
    <div>
        <x-input-label for="judul" :value="__('Judul Dokumen')" />
        <x-text-input id="judul" type="text" name="judul" :value="old('judul', $dokumen->judul ?? '')" required class="block w-full mt-1" />
        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="kategori_tag" :value="__('Kategori / Tag')" />
            <x-text-input id="kategori_tag" type="text" name="kategori_tag" :value="old('kategori_tag', $dokumen->kategori_tag ?? '')" class="block w-full mt-1" placeholder="SOP, Manual, Hasil Rapat, dll." />
        </div>
        <div>
            <x-input-label for="versi" :value="__('Versi')" />
            <x-text-input id="versi" type="text" name="versi" :value="old('versi', $dokumen->versi ?? '')" class="block w-full mt-1" placeholder="1.0, 2.0, dst." />
        </div>
    </div>

    <div>
        <x-input-label for="file" :value="__('File')" />
        <input id="file" type="file" name="file" 
            class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            {{ isset($dokumen) ? '' : 'required' }}>
        @if(isset($dokumen) && $dokumen->file_path)
            <p class="text-sm text-gray-500 mt-1">File saat ini: {{ $dokumen->file_path }} (biarkan kosong jika tidak ingin mengubah file)</p>
        @endif
        <x-input-error :messages="$errors->get('file')" class="mt-2" />
    </div>

    @if(isset($dokumen))
    <div>
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" class="block w-full mt-1 rounded-md border-gray-300">
            <option value="aktif" {{ old('status', $dokumen->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="arsip" {{ old('status', $dokumen->status ?? '') == 'arsip' ? 'selected' : '' }}>Arsip</option>
        </select>
    </div>
    @endif
</div>