<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'aksi',
        'nama_tabel',
        'record_id',
        'data_lama',
        'data_baru',
        'ip_address',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}