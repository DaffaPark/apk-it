<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'prioritas',
        'assignee_id',
        'tiket_id',
        'deadline',
        'completed_at',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}