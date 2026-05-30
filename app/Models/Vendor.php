<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use Loggable;
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