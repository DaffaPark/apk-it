<?php

namespace App\Models;

use App\Traits\Loggable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'unit'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Loggable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tiketDilaporkan()
    {
        return $this->hasMany(Tiket::class, 'pelapor_id');
    }

    public function tiketDitangani()
    {
        return $this->hasMany(Tiket::class, 'teknisi_id');
    }

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class, 'assignee_id');
    }
}