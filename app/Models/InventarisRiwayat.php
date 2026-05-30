<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class InventarisRiwayat extends Model
{
    use Loggable;
    public $timestamps = false;
    protected $fillable = [
        'inventaris_id',
        'jenis_aktivitas',
        'deskripsi',
        'tiket_id',
        'biaya',
        'teknisi_id',
    ];
    protected $casts = ['created_at' => 'datetime'];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }
}