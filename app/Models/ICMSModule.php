<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use App\Models\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\HasOneThrough;
// use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
// use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\HasManyThrough;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// load helper
use Illuminate\Support\Str;

class ICMSModule extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql3';
    protected $table = 'icms_modules';
    // protected $primaryKey = '';
    // public $incrementing = false;
    // protected $keyType = '';
    // const CREATED_AT = '';
    // const UPDATED_AT = '';
    // protected $rememberTokenName = '';


    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // set column attribute
    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = ucwords(Str::lower($value));
    // }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // relationship
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // belongstomany relationship
    public function belongstomanyicmsrequesterapplicant(): BelongsToMany
    {
        // return $this->belongsTo(\App\Models\ICMSModule::class, 'icms_applicant_modules', 'icms_applicant_module_id', 'icms_module_id' )->withTimestamps();
        return $this->BelongsToMany(\App\Models\ICMSRequesterApplicant::class, 'icms_applicant_modules', 'icms_module_id', 'icms_applicant_module_id')->using(ICMSApplicantModule::class)->withTimestamps();
    }

}
