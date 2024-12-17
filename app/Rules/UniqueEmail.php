<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Login;
use App\Models\EmailSuggestion;

class UniqueEmail implements Rule
{
	public function passes($attribute, $value)
	{
		// dd($value, $emails);
		$r1 = [];
		$r2 = [];
		foreach ($value as $v1) {
			$r1[] = $v1['email_suggestion'];
		}

		$emails = Login::where('is_active', 1)->whereNotNull('email')->pluck('email')->toArray();
		foreach ($emails as $v2) {
			$r2[] = explode('@', $v2)[0];
		}

		$mails = EmailSuggestion::where('approved_email', 1)->pluck('email_suggestion')->toArray();
		foreach ($mails as $v3) {
			$r2[] = $v3;
		}

		$found = false;
		foreach ($r1 as $item) {
			if (in_array($item, $r2)) {
				$found = true;
				break;  // Exit loop once we find a match
			}
		}

		if ($found) {
			return false;
		} else {
			return true;
		}
	}

	public function message()
	{
		return 'Please use another email, this email already exist in the system';
	}
}
