<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPemeliharaan extends Model
{
    protected $fillable = [
        'nama',
        'jenis',
        'frekuensi_hari',
        'tanggal_mulai',
        'inventaris_id',
        'reminder_h3',
        'checklist_json',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'checklist_json' => 'array',
        'reminder_h3' => 'boolean',
        'is_active' => 'boolean',
        'tanggal_mulai' => 'date',
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pelaksanaans()
    {
        return $this->hasMany(JadwalPelaksanaan::class);
    }
}