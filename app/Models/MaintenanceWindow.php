<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class MaintenanceWindow extends Model
{
    use Loggable;
    protected $fillable = [
        'nama',
        'mulai',
        'selesai',
        'gedung_terdampak',
        'pelaksana_id',
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
    ];

    public function pelaksana()
    {
        return $this->belongsTo(User::class, 'pelaksana_id');
    }
}