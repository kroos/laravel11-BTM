<?php

namespace App\Providers\Auth;

use Illuminate\Support\ServiceProvider;


// using this to override Illuminate\Auth\EloquentUserProvider
// what to override
use Illuminate\Auth\EloquentUserProvider as BaseUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

// class EloquentUserProvider extends ServiceProvider
class EloquentUserProvider extends BaseUserProvider
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

	// public function retrieveById($identifier)
	// {
	// 	$model = $this->createModel();
	// 	return $model->setConnection('mysql1')->newQuery()->find($identifier);
	// }

	// public function retrieveByCredentials(array $credentials)
	// {
	// 	if (empty($credentials)) {
	// 		return;
	// 	}

	// 	$query = $this->createModel()->setConnection('mysql1')->newQuery();

	// 	foreach ($credentials as $key => $value) {
	// 		if (! str_contains($key, 'password')) {
	// 			$query->where($key, $value);
	// 		}
	// 	}

	// 	return $query->first();
	// }

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
