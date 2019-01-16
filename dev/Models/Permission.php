<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model{
//	protected $table = "permissions";
	protected $fillable = ["name"];

	public function roles(){
		/*return $this->hasManyThrough(
			Role::class, RolePermission::class,
			"permission_id", "id",
			"id", "role_id"
		);*/
		return $this->belongsToMany(Role::class)
		->using(RolePermission::class)
//		->as("grant")
		->withTimestamps();
	}
}