<?php
namespace App\Models;

class Admin extends Model{
//	protected $table = "admins";
	protected $fillable = [""];

	public function user(){
		return $this->belongsTo(User::class);
	}
}
