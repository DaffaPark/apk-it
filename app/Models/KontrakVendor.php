<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontrakVendor extends Model
{
    protected $fillable = [
        'vendor_id',
        'inventaris_id',
        'no_kontrak',
        'tanggal_mulai',
        'tanggal_berakhir',
        'nilai_kontrak',
        'kontak_darurat',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}