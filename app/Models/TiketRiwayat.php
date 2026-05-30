<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class TiketRiwayat extends Model
{
    use Loggable;
    public $timestamps = false;
    protected $fillable = ['tiket_id', 'user_id', 'old_status', 'new_status', 'catatan'];
    protected $casts = ['created_at' => 'datetime'];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}