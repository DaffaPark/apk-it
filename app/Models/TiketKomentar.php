<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketKomentar extends Model
{
    protected $fillable = ['tiket_id', 'user_id', 'pesan', 'lampiran_url'];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}