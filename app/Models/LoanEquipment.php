<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use App\Models\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\HasOneThrough;
// use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LoanEquipment extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'loan_equipments';

	use HasFactory;

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	public function hasmanyapprover(): HasMany
	{
		return $this->hasMany(\App\Models\Staff::class, 'nostaf');
	}

	// public function hasmany(): HasMany
	// {
	// 	return $this->hasMany(\App\Models\Staff::class, 'nostaf');
	// }

	// public function hasmanydept(): HasMany
	// {
	// 	return $this->hasMany(\App\Models\Jabatan::class, 'kodjabatan', 'kod_jabatan');
	// }

	/////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship
	public function belongstoloan(): BelongsTo
	{
		return $this->belongsTo(\App\Models\LoanApplication::class, 'application_id')->withDefault();
	}

	public function belongstoequipment(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Settings\Item::class, 'equipment_id')->withDefault();
	}

	public function belongstoequipmentstatus(): BelongsTo
	{
		return $this->belongsTo(\App\Models\StatusEquipment::class, 'status_item_id')->withDefault();
	}
}
