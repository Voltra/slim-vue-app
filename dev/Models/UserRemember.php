<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRemember extends Model{
	protected $table = "user_remember";
	protected $fillable = ["user_id", "remember_id", "remember_token"];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function rid(): ?string{
		return $this->remember_id;
	}

	public function token(): ?string{
		return $this->remember_token;
	}

	public function hasID(): bool{
		return !is_null($this->rid());
	}

	public function hasToken(): bool{
		return !is_null($this->token());
	}

	public function updateCredentials(?string $id, ?string $token): bool{
		return $this->update([
			"remember_id" => $id,
			"remember_token" => $token
		]);
	}

	public function reset(): bool{
		return $this->updateCredentials(null, null);
	}

	public function scopeFromRID(/*Builder*/ $query, string $rid): ?self{
		return $query->where("remember_id", $rid)->first();
	}

	public static function make(User $user, ?string $id, ?string $token): ?self{
		return self::create([
			"user_id" => $user->id,
			"remember_id" => $id,
			"remember_token" => $token
		]);
	}
}