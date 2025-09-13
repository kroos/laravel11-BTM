<?php

namespace App\Models;

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

// load helper
use Illuminate\Support\Str;

class ICMSRequester extends Model
{
	use SoftDeletes;
	protected $connection = 'mysql3';
	protected $table = 'icms_requesters';
	// protected $primaryKey = '';
	// public $incrementing = false;
	// protected $keyType = '';
	// const CREATED_AT = '';
	// const UPDATED_AT = '';
	// protected $rememberTokenName = '';


	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// set column attribute
	public function setApproverRemarksAttribute($value)
	{
	    $this->attributes['approver_remarks'] = ucwords(Str::lower($value));
	}

	public function setBTMRemarksAttribute($value)
	{
	    $this->attributes['btm_remarks'] = ucwords(Str::lower($value));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// relationship
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship
	public function belongstostaff(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Staff::class, 'nostaf');
	}

	public function belongstostatusrequest(): BelongsTo
	{
		return $this->belongsTo(\App\Models\StatusApplication::class, 'status_request_id')->withDefault();
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	public function hasmanyapplicant(): HasMany
	{
		return $this->hasMany(\App\Models\ICMSRequesterApplicant::class, 'icms_requester_id');
	}

	/////////////////////////////////////////////////////////////////////////////////////////
}
