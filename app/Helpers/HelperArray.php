<?php
namespace App\Helpers;

class HelperArray
{
	/**
	 * Create a new class instance.
	 */
	public function __construct()
	{
		//
	}

	public static function prepareModulesForSync(array $modules): array
	{
		$ids = [];
		$lastNumericId = null;

		foreach ($modules as $key => $val) {
			// skip the remarks remark here; we'll handle it after collecting numeric ids
			if (is_string($key) && strtolower($key) === 'remarks') {
				continue;
			}

			// if the value itself is an array, flatten it
			if (is_array($val)) {
				foreach ($val as $sub) {
					if ($sub === '' || $sub === null) continue;
					if (is_numeric($sub) || ctype_digit((string)$sub)) {
						$ids[] = (int) $sub;
						$lastNumericId = (int) $sub;
					}
				}
				continue;
			}

			// scalar value: treat numeric strings as module ids
			if ($val === '' || $val === null) continue;
			if (is_numeric($val) || ctype_digit((string)$val)) {
				$ids[] = (int) $val;
				$lastNumericId = (int) $val;
			}
		}

		// build associative sync array (id => pivot-array). empty array means no pivot data.
		$sync = [];
		foreach ($ids as $id) {
			$sync[$id] = [];
		}

		// if a remarks remark exists, attach it to the last numeric id encountered
		if (array_key_exists('remarks', $modules) && $lastNumericId !== null) {
			$sync[$lastNumericId] = ['remarks' => $modules['remarks']];
		}

		return $sync;
	}

}
