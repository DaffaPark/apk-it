<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsidenLog extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'insiden_siber_id',
        'user_id',
        'aksi',
        'catatan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function insiden()
    {
        return $this->belongsTo(InsidenSiber::class, 'insiden_siber_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}