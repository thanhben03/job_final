<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\ServiceProvider;

class CompanyUserProvider extends EloquentUserProvider
{
    /**
     * Register services.
     */
    public function validateCredentials(UserContract|Authenticatable $user, array $credentials): bool
    {
        if (is_null($plain = $credentials['company_password'])) {
            return false;
        }

        return $this->hasher->check($plain, $user->company_password, ['salt' => $user->salt]);
    }
}
