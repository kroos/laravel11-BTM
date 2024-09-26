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
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Staff extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'staf_peribadi';

	use HasFactory, SoftDeletes;

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	public function hasmanylogin(): HasMany
	{
		return $this->hasMany(\App\Models\Login::class, 'nostaf');
	}


	/////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship






}
