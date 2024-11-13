<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use App\Models\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\HasOneThrough;
// use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
// use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BTMApprover extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'btm_approval';
	// protected $primaryKey = 'nostaf';
	// protected $keyType = 'string';

	use HasFactory/*, SoftDeletes*/;

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	public function hasmanyloanapplication(): HasMany
	{
		return $this->hasMany(\App\Models\LoanApplication::class, 'btm_approver');
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship
	public function belongstobtmappr(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Staff::class, 'nostaf')->withDefault();
	}

}
