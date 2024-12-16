<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyOneTempPassword implements Rule
{
	public function passes($attribute, $value)
	{
		// dd($value);
		$tempPasswordCount = 0;
		$approvedEmailCount = 0;

		foreach ($value as $item) {
			if (!is_null($item['temp_password'])) {
					$tempPasswordCount++;
			}

			if (!is_null($item['approved_email'])) {
					$approvedEmailCount++;
			}

			if ( $tempPasswordCount == 1 && $approvedEmailCount == 1 ) {
					return true;
			}
		}

		return false;
	}

	public function message()
	{
		return 'Only one Temporary Password and one Approved Email can be set.';
	}
}
