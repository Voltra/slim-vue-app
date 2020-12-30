<?php
namespace App\Models;

class Permission extends Model{
//	protected $table = "permissions";
	protected $fillable = ["name"];

	public function roles(){
		return $this->belongsToMany(Role::class)
		->using(RolePermission::class)
//		->as("grant")
		->withTimestamps();
	}
}
