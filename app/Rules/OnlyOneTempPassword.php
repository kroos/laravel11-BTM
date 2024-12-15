<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyOneTempPassword implements Rule
{
	public function passes($attribute, $value)
	{
		$tempPasswordCount = 0;
		$approvedEmailCount = 0;

		foreach ($value as $item) {
			if (!empty($item['temp_password'])) {
					$tempPasswordCount++;
			}

			if (!empty($item['approved_email'])) {
					$approvedEmailCount++;
			}

			if ($tempPasswordCount > 1 || $approvedEmailCount > 1) {
					return false;
			}
		}

		return true;
	}

	public function message()
	{
		return 'Only one temporary password and one approved email can be set.';
	}
}
