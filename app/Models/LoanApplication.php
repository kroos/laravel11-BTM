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

class LoanApplication extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'loan_applications';

	use HasFactory;

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	public function hasmanyequipments(): HasMany
	{
		return $this->hasMany(\App\Models\LoanEquipment::class, 'application_id');
	}

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
		return $this->belongsTo(\App\Models\Staff::class, 'approver_staff')->withDefault();
	}

	public function belongstobtmappr(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Staff::class, 'btm_approver')->withDefault();
	}

	public function belongstostaff(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Staff::class, 'nostaf')->withDefault();
	}

	public function belongstostatusloan(): BelongsTo
	{
		return $this->belongsTo(\App\Models\StatusLoan::class, 'status_loan_id')->withDefault();
	}

	public function belongstoapproverstatusloan(): BelongsTo
	{
		return $this->belongsTo(\App\Models\StatusApproval::class, 'approver_status_id')->withDefault();
	}


}
