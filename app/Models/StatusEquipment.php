<?php

namespace App\Models;

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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StatusEquipment extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'status_equipments';
	// protected $primaryKey = 'kodjabatan';
	// protected $keyType = 'string';


	use HasFactory/*, SoftDeletes*/;

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasone relationship
	// public function hasmanyapproval(): HasMany
	// {
	// 	return $this->hasMany(\App\Models\Login::class, 'nostaf');
	// }

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	public function hasmanyequipmentstatus(): HasMany
	{
		return $this->hasMany(\App\Models\Settings\Item::class, 'status_item_id');
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship
	// public function belongstojabatan(): BelongsTo
	// {
	// 	return $this->belongsTo(\App\Models\Staff::class, 'nostaf');
	// }

	/////////////////////////////////////////////////////////////////////////////////////////
	// BelongsToMany relationship
	// public function belongstomanyappr(): BelongsToMany
	// {
	// 	return $this->belongsToMany(\App\Models\Staff::class, env('DB_DATABASE_3').'.dept_approval', 'kod_jabatan', 'nostaf')->using(\App\Models\DepartmentApproval::class)->withPivot( 'kod_jabatan', 'nostaf', 'active')->wherePivot('active', 1);
	// }

	// public function belongstomanystaff(): BelongsToMany
	// {
	// 	return $this->belongsToMany(\App\Models\Staff::class, 'stf_jabatan', 'kod_jab', 'nostaf')->using(\App\Models\StaffJabatan::class)->withPivot( 'kod_jab', 'nostaf', 'terkini')->wherePivot('terkini', 1);
	// }



}
