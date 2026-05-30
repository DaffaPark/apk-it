<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsidenSiber extends Model
{
    protected $table = 'insiden_sibers';

    protected $fillable = [
        'jenis_serangan',
        'sumber_ip',
        'detail',
        'severity',
        'status',
        'tiket_id',
        'resolved_at',
    ];

    protected $casts = [
        'detected_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function logs()
    {
        return $this->hasMany(InsidenLog::class, 'insiden_siber_id');
    }
}