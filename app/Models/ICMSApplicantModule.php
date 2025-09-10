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
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// load helper
use Illuminate\Support\Str;

class ICMSApplicantModule extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql3';
    protected $table = 'icms_applicant_modules';
    // protected $primaryKey = '';
    // public $incrementing = false;
    // protected $keyType = '';
    // const CREATED_AT = '';
    // const UPDATED_AT = '';
    // protected $rememberTokenName = '';


    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // set column attribute
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(Str::lower($value));
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // relationship
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // belongsto relationship
    public function belongstoicmsrequester(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ICMSRequester::class, 'icms_requester_id');
    }

    public function belongstoicmsapplicant(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Staff::class, 'nostaf');
    }

    /////////////////////////////////////////////////////////////////////////////////////////
    // hasmany relationship
    public function hasmanyicmsmodule(): HasMany
    {
        return $this->hasMany(\App\Models\ICMSModule::class, 'icms_module_id');
    }

}
