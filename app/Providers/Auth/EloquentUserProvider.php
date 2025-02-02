<?php

namespace App\Providers\Auth;

use Illuminate\Support\ServiceProvider;


// using this to override Illuminate\Auth\EloquentUserProvider
// what to override
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

// class EloquentUserProvider extends ServiceProvider
class EloquentUserProvider extends UserProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        // dd($user->belongstostaff->status);
        $plain = $credentials['password'];
        // dd($plain, $credentials['password']);
        // this is for plain text user password
        // dd($plain, $user->getAuthPassword());
        // if (($plain == $user->getAuthPassword() && $user->is_active == 1)) {
        //     return true;
        // } else {
        //     return false;
        // }
        // return ($this->hasher->check($plain, $user->getAuthPassword())  && ($user->belongstostaff->status == 'A' && $user->is_active == 1));
        if (($user->belongstostaff->status == 'A') && ($user->is_active == 1) && ($this->hasher->check($plain, $user->getAuthPassword()))) {
            return true;
        }
    }
}
