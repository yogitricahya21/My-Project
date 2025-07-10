<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Loan;
use App\Models\Activity;
use App\Models\InboundTransaction;
use App\Models\OutboundTransaction;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

     // Relasi ke transaksi masuk
    public function inboundTransactions()
    {
        return $this->hasMany(InboundTransaction::class);
    }

    // Relasi ke transaksi keluar
    public function outboundTransactions()
    {
        return $this->hasMany(OutboundTransaction::class);
    }

    // Relasi ke peminjaman
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // Relasi ke kegiatan
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
