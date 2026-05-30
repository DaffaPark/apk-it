<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\Loggable;

class Tiket extends Model
{
    use Loggable;
    protected $fillable = [
        'kode_unik',
        'pelapor_id',
        'pelapor_nama',
        'pelapor_unit',
        'pelapor_email',
        'keluhan',
        'penyebab',
        'solusi',
        'prioritas',
        'kategori',
        'status',
        'teknisi_id',
        'parent_tiket_id',
        'sla_deadline',
        'eskalasi_terakhir',
        'feedback_rating',
        'feedback_catatan',
        'resolved_at',
    ];

    protected $casts = [
        'sla_deadline' => 'datetime',
        'eskalasi_terakhir' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($tiket) {
            $tiket->kode_unik = (string) Str::uuid();
            
            // Hitung SLA deadline berdasarkan prioritas
            $slaHours = match ($tiket->prioritas) {
                'low'      => 24,
                'medium'   => 12,
                'high'     => 4,
                'critical' => 1,
                default    => 24,
            };
            $tiket->sla_deadline = now()->addHours($slaHours);
        });
    }

    public function insiden()
    {
        return $this->hasOne(InsidenSiber::class, 'tiket_id');
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function parent()
    {
        return $this->belongsTo(Tiket::class, 'parent_tiket_id');
    }

    public function children()
    {
        return $this->hasMany(Tiket::class, 'parent_tiket_id');
    }

    public function riwayat()
    {
        return $this->hasMany(TiketRiwayat::class);
    }

    public function komentars()
    {
        return $this->hasMany(TiketKomentar::class);
    }

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class);
    }
}