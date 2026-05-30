<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelaksanaan extends Model
{
    protected $fillable = [
        'jadwal_pemeliharaan_id',
        'teknisi_id',
        'status',
        'hasil_checklist_json',
        'catatan',
        'dilaksanakan_pada',
    ];

    protected $casts = [
        'hasil_checklist_json' => 'array',
        'dilaksanakan_pada' => 'datetime',
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalPemeliharaan::class, 'jadwal_pemeliharaan_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }
}