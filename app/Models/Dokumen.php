<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
        'judul',
        'kategori_tag',
        'is_versi_terbaru',
        'versi',
        'file_path',
        'uploaded_by',
        'status',
    ];

    protected $casts = [
        'is_versi_terbaru' => 'boolean',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}