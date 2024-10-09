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

class Approver extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'dept_approval';
	// protected $primaryKey = 'flight_id';

	use HasFactory/*, SoftDeletes*/;

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	// public function hasmanyapprover(): HasMany
	// {
	// 	return $this->hasMany(\App\Models\Staff::class, 'nostaf');
	// }

	// public function hasmanydept(): HasMany
	// {
	// 	return $this->hasMany(\App\Models\Jabatan::class, 'kodjabatan', 'kod_jabatan');
	// }

	/////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship
	public function belongstoappr(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Staff::class, 'nostaf')->withDefault();
	}

	public function belongstodeptappr(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Jabatan::class, 'kod_jabatan')->withDefault();
	}

}
