<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected string $guard = 'company';

    protected $guarded = [];

//    protected function casts(): array
//    {
//        return [
//            'password' => 'hashed',
//        ];
//    }

    public function careers(): HasMany
    {
        return $this->hasMany(Career::class);
    }

}
