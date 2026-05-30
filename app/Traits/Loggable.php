<?php

namespace App\Traits;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

trait Loggable
{
    public static function bootLoggable()
    {
        // Log saat data dibuat
        static::created(function ($model) {
            $model->logActivity('CREATE', null, $model->getAttributes());
        });

        // Log saat data diperbarui
        static::updated(function ($model) {
            $model->logActivity('UPDATE', $model->getOriginal(), $model->getChanges());
        });

        // Log saat data dihapus
        static::deleted(function ($model) {
            $model->logActivity('DELETE', $model->getOriginal(), null);
        });
    }

    protected function logActivity(string $aksi, ?array $dataLama, ?array $dataBaru)
    {
        // Abaikan kolom sensitif
        $exclude = ['password', 'password_hash', 'remember_token', 'created_at', 'updated_at'];

        if ($dataLama) {
            $dataLama = array_diff_key($dataLama, array_flip($exclude));
        }
        if ($dataBaru) {
            $dataBaru = array_diff_key($dataBaru, array_flip($exclude));
        }

        // Jangan catat kalau data lama dan baru kosong (misal saat event terpicu tanpa perubahan nyata)
        if (empty($dataLama) && empty($dataBaru)) {
            return;
        }

        LogAktivitas::create([
            'user_id'    => Auth::id(),
            'aksi'       => $aksi,
            'nama_tabel' => $this->getTable(),
            'record_id'  => $this->getKey(),
            'data_lama'  => $dataLama,
            'data_baru'  => $dataBaru,
            'ip_address' => request()->ip(),
        ]);
    }
}