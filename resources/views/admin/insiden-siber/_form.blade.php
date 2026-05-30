<div class="space-y-4">
    <div>
        <x-input-label for="jenis_serangan" :value="__('Jenis Serangan')" />
        <x-text-input id="jenis_serangan" type="text" name="jenis_serangan" :value="old('jenis_serangan', $insidenSiber->jenis_serangan ?? '')" required class="block w-full mt-1" />
        <x-input-error :messages="$errors->get('jenis_serangan')" class="mt-2" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="sumber_ip" :value="__('Sumber IP')" />
            <x-text-input id="sumber_ip" type="text" name="sumber_ip" :value="old('sumber_ip', $insidenSiber->sumber_ip ?? '')" class="block w-full mt-1" placeholder="192.168.1.100" />
        </div>
        <div>
            <x-input-label for="severity" :value="__('Severity')" />
            <select id="severity" name="severity" required class="block w-full mt-1 rounded-md border-gray-300">
                <option value="low" {{ old('severity', $insidenSiber->severity ?? '') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ old('severity', $insidenSiber->severity ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ old('severity', $insidenSiber->severity ?? '') == 'high' ? 'selected' : '' }}>High</option>
                <option value="critical" {{ old('severity', $insidenSiber->severity ?? '') == 'critical' ? 'selected' : '' }}>Critical</option>
            </select>
        </div>
    </div>

    <div>
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" required class="block w-full mt-1 rounded-md border-gray-300">
            <option value="terdeteksi" {{ old('status', $insidenSiber->status ?? '') == 'terdeteksi' ? 'selected' : '' }}>Terdeteksi</option>
            <option value="dalam_penanganan" {{ old('status', $insidenSiber->status ?? '') == 'dalam_penanganan' ? 'selected' : '' }}>Dalam Penanganan</option>
            <option value="selesai" {{ old('status', $insidenSiber->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="false_positive" {{ old('status', $insidenSiber->status ?? '') == 'false_positive' ? 'selected' : '' }}>False Positive</option>
        </select>
    </div>

    <div>
        <x-input-label for="detail" :value="__('Detail')" />
        <textarea id="detail" name="detail" rows="3" class="block w-full mt-1 rounded-md border-gray-300">{{ old('detail', $insidenSiber->detail ?? '') }}</textarea>
    </div>

    <div>
        <x-input-label for="tiket_id" :value="__('Terkait Tiket (opsional)')" />
        <x-text-input id="tiket_id" type="number" name="tiket_id" :value="old('tiket_id', $insidenSiber->tiket_id ?? '')" class="block w-full mt-1" />
    </div>
</div>