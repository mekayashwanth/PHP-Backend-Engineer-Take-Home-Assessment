<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['username', 'password', 'is_lender'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function loansAsLender(): HasMany {
        return $this->hasMany(Loan::class, 'lender_id');
    }

    public function loansAsBorrower(): HasMany {
        return $this->hasMany(Loan::class, 'borrower_id');
    }
}
