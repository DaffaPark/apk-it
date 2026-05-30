<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'nama_vendor',
        'kontak',
        'telepon',
        'email',
        'alamat',
    ];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }

    public function kontrakVendors()
    {
        return $this->hasMany(KontrakVendor::class);
    }
}