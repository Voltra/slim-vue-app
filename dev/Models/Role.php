<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{
//	protected $table = "roles";
	protected $fillable = ["name"];

	public function permissions(){
		/*return $this->hasManyThrough(
			Permission::class,RolePermission::class,
			"role_id", "id",
			"id", "permission_id"
		);*/
		return $this->belongsToMany(Permission::class)
		->using(RolePermission::class)
//		->as("grant")
		->withTimestamps();
	}

	public function users(){
		/*return $this->hasManyThrough(
			User::class, UserRole::class,
			"role_id", "id",
			"id", "user_id"
		);*/
		return $this->belongsToMany(User::class)
		->using(UserRole::class)
//		->as("grant")
		->withTimestamps();
	}
}