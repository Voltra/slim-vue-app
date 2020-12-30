<?php
namespace App\Models;

class Role extends Model{
//	protected $table = "roles";
	protected $fillable = ["name"];

	public function permissions(){
		return $this->belongsToMany(Permission::class)
		->using(RolePermission::class)
//		->as("grant")
		->withTimestamps();
	}

	public function users(){
		return $this->belongsToMany(User::class)
		->using(UserRole::class)
//		->as("grant")
		->withTimestamps();
	}
}
