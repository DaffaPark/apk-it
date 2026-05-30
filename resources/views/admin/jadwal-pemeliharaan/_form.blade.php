<div class="space-y-4">
    {{-- Nama Jadwal --}}
    <div>
        <x-input-label for="nama" :value="__('Nama Jadwal')" />
        <x-text-input 
            id="nama" 
            type="text" 
            name="nama" 
            :value="old('nama', $jadwalPemeliharaan->nama ?? '')" 
            required 
            class="block w-full mt-1" 
        />
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>

    {{-- Jenis & Frekuensi --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="jenis" :value="__('Jenis')" />
            <select id="jenis" name="jenis" required class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="rutin" {{ old('jenis', $jadwalPemeliharaan->jenis ?? '') == 'rutin' ? 'selected' : '' }}>Rutin</option>
                <option value="sekali" {{ old('jenis', $jadwalPemeliharaan->jenis ?? '') == 'sekali' ? 'selected' : '' }}>Sekali</option>
            </select>
            <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="frekuensi_hari" :value="__('Frekuensi (hari)')" />
            <x-text-input 
                id="frekuensi_hari" 
                type="number" 
                name="frekuensi_hari" 
                :value="old('frekuensi_hari', $jadwalPemeliharaan->frekuensi_hari ?? '')" 
                class="block w-full mt-1" 
            />
            <x-input-error :messages="$errors->get('frekuensi_hari')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Diisi jika jenis "Rutin".</p>
        </div>
    </div>

    {{-- Tanggal Mulai --}}
    <div>
        <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
        <x-text-input 
            id="tanggal_mulai" 
            type="date" 
            name="tanggal_mulai" 
            :value="old('tanggal_mulai', isset($jadwalPemeliharaan->tanggal_mulai) ? $jadwalPemeliharaan->tanggal_mulai->format('Y-m-d') : '')" 
            required 
            class="block w-full mt-1" 
        />
        <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
    </div>

    {{-- Perangkat Terkait --}}
    <div>
        <x-input-label for="inventaris_id" :value="__('Perangkat Terkait')" />
        <select id="inventaris_id" name="inventaris_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">-- Tidak ada --</option>
            @foreach($inventaris as $item)
                <option value="{{ $item->id }}" {{ old('inventaris_id', $jadwalPemeliharaan->inventaris_id ?? '') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_perangkat }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('inventaris_id')" class="mt-2" />
    </div>

    {{-- Checkbox Reminder H-3 & Aktif --}}
    <div class="flex gap-6">
        <label class="flex items-center gap-2">
            <input 
                type="checkbox" 
                name="reminder_h3" 
                value="1" 
                {{ old('reminder_h3', $jadwalPemeliharaan->reminder_h3 ?? true) ? 'checked' : '' }} 
                class="rounded border-gray-300 shadow-sm focus:ring-indigo-500"
            >
            <span class="text-sm text-gray-700">Reminder H-3</span>
        </label>
        <label class="flex items-center gap-2">
            <input 
                type="checkbox" 
                name="is_active" 
                value="1" 
                {{ old('is_active', $jadwalPemeliharaan->is_active ?? true) ? 'checked' : '' }} 
                class="rounded border-gray-300 shadow-sm focus:ring-indigo-500"
            >
            <span class="text-sm text-gray-700">Aktif</span>
        </label>
    </div>

    {{-- Template Checklist JSON --}}
    <div>
        <x-input-label for="checklist_json" :value="__('Template Checklist (JSON)')" />
        <textarea 
            id="checklist_json" 
            name="checklist_json" 
            rows="3" 
            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
            placeholder='["Cek suhu", "Test UPS", "Bersihkan panel"]'
        >{{ old('checklist_json', isset($jadwalPemeliharaan->checklist_json) ? json_encode($jadwalPemeliharaan->checklist_json) : '') }}</textarea>
        <x-input-error :messages="$errors->get('checklist_json')" class="mt-2" />
        <p class="text-xs text-gray-500 mt-1">Format JSON array. Contoh: ["Item 1", "Item 2"]</p>
    </div>
</div>