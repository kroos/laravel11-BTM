<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * A list of exception types with their corresponding custom log levels.
	 *
	 * @var array, \Psr\Log\LogLevel::*>
	 */
	protected $levels = [

	];

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array>
	 */
	protected $dontReport = [

	];

	/**
	 * A list of the inputs that are never flashed to the session on validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'current_password',
		'password',
		'password_confirmation',
	];

	/**
	 * Register the exception handling callbacks for the application.
	 */
	public function register(): void
	{
		$this->reportable(function (Throwable $e) {

		});
	}

	/**
	 * Write code on Method
	 *
	 * @return response()
	 */

	public function render($request, Exception|Throwable $e)
	{
		if ($e instanceof ModelNotFoundException) {
		// 	return response()->json(['error' => 'Data not found.']);
			return response()->view('errors.' . '404', [], 404);
		}
		return parent::render($request, $e);
	}

/////////////////////////////////////////////////////////
	// original
	/**
	 * The list of the inputs that are never flashed to the session on validation exceptions.
	 *
	 * @var array<int, string>
	 */
	// protected $dontFlash = [
	// 	'current_password',
	// 	'password',
	// 	'password_confirmation',
	// ];

	/**
	 * Register the exception handling callbacks for the application.
	 */
	// public function register(): void
	// {
	// 	$this->reportable(function (Throwable $e) {
	// 		//
	// 	});
	// }
}
