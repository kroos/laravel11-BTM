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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Staff extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'staf_peribadi';
	protected $primaryKey = 'nostaf';
	protected $keyType = 'string';

	use HasFactory/*, SoftDeletes*/;

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasone relationship
	// public function hasmanyapproval(): HasMany
	// {
	// 	return $this->hasMany(\App\Models\Login::class, 'nostaf');
	// }

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	public function hasmanylogin(): HasMany
	{
		return $this->hasMany(\App\Models\Login::class, 'nostaf');
	}

	public function hasmanyloan(): HasMany
	{
		return $this->hasMany(\App\Models\LoanApplication::class, 'nostaf');
	}

	public function hasmanybtmapprover(): HasMany
	{
		return $this->hasMany(\App\Models\Settings\BTMApprover::class, 'nostaf');
	}

	public function hasmanyemailregistration(): HasMany
	{
		return $this->hasMany(\App\Models\EmailRegistrationApplication::class, 'nostaf');
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship
	// public function belongstojabatan(): BelongsTo
	// {
	// 	return $this->belongsTo(\App\Models\Jabatan::class, 'nostaf');
	// }

	/////////////////////////////////////////////////////////////////////////////////////////
	// BelongsToMany relationship
	public function belongstomanydeptappr(): BelongsToMany
	{
			return $this->belongsToMany(\App\Models\Jabatan::class, env('DB_DATABASE_3').'.dept_approval', 'nostaf', 'kod_jabatan')->using(\App\Models\DepartmentApproval::class)->withPivot('nostaf', 'kod_jabatan', 'active')->wherePivot('active', 1);
	}

	public function belongstomanydepartment(): BelongsToMany
	{
			return $this->belongsToMany(\App\Models\Jabatan::class, 'stf_jabatan', 'nostaf', 'kod_jab')->using(\App\Models\StaffJabatan::class)->withPivot('nostaf', 'kod_jab', 'terkini')->wherePivot('terkini', 1);
	}




}
