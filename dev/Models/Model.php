<?php


namespace App\Models;

use Illuminate\Database\Query\Builder;

/**
 * Class Model
 * @package App\Models
 * @mixin \Eloquent
 * @method static static|null findBy($key, $value)
 * @method static static findByOrFail($key, $value)
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
	public function scopeFindBy($query, $key, $value){
		return $query->where($key, "=", $value)->first();
	}

	public function scopeFindByOrFail($query, $key, $value){
		return $query->where($key, "=", $value)->firstOrFail();
	}
}
