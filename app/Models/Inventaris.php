<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $fillable = [
        'kode_qr',
        'nama_perangkat',
        'jenis',
        'induk_id',
        'kategori',
        'serial_number',
        'model',
        'status_kondisi',
        'lokasi_gedung',
        'lokasi_lantai',
        'lokasi_ruangan',
        'area_klinis',
        'tanggal_pembelian',
        'estimasi_masa_pakai_bulan',
        'garansi_berakhir',
        'vendor_id',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'garansi_berakhir' => 'date',
        'area_klinis' => 'boolean',
    ];

    public function induk()
    {
        return $this->belongsTo(Inventaris::class, 'induk_id');
    }

    public function komponen()
    {
        return $this->hasMany(Inventaris::class, 'induk_id');
    }

    public function riwayat()
    {
        return $this->hasMany(InventarisRiwayat::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function jadwalPemeliharaans()
    {
        return $this->hasMany(JadwalPemeliharaan::class, 'inventaris_id');
    }

    public function peminjamanAssets()
    {
        return $this->hasMany(PeminjamanAset::class, 'inventaris_id');
    }
}