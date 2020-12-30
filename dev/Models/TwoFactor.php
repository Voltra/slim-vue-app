<?php


namespace App\Models;


class TwoFactor extends Model
{
	protected $table = "2fa";
	protected $fillable = ["discriminant", "latest_code"];

	public function user(){
		return $this->belongsTo(User::class);
	}
}
