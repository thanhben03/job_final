<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;


class CompanyUserProvider extends UserProvider {

    /**
     * Overrides the framework defaults validate credentials method
     *
     * @param UserContract $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials) {
        $plain = $credentials['password'];

        // PUT YOUR CUSTOM VALIDATION HERE

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

}
