<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAset extends Model
{
    use Loggable;
    protected $fillable = [
        'inventaris_id',
        'peminjam_id',
        'nama_peminjam',
        'unit_peminjam',
        'tujuan',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali_rencana' => 'datetime',
        'tanggal_kembali_aktual' => 'datetime',
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }
}