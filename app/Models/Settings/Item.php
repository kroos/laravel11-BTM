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

// load helper
use Illuminate\Support\Str;

class Item extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'equipments';

	use HasFactory/*, SoftDeletes*/;

	/////////////////////////////////////////////////////////////////////////////////////////
	// change value attribute
	public function setDescriptionAttribute($value)
	{
		$this->attributes['description'] = Str::lower($value);
	}

	public function setItemAttribute($value)
	{
		$this->attributes['item'] = ucwords(Str::lower($value));
	}

	public function setBrandAttribute($value)
	{
		$this->attributes['brand'] = Str::upper(Str::lower($value));
	}

	public function setModelAttribute($value)
	{
		$this->attributes['model'] = Str::upper(Str::lower($value));
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	// hasmany relationship
	// public function hasmanylogin(): HasMany
	// {
	// 	return $this->hasMany(\App\Models\Item::class, 'category_id');
	// }

	/////////////////////////////////////////////////////////////////////////////////////////
	// belongsto relationship
	public function belongstocategory(): BelongsTo
	{
		return $this->belongsTo(\App\Models\Settings\Category::class, 'category_id')->withDefault();
	}
}
