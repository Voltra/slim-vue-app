<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class User extends Model{
//	protected $table = "users";
	protected $fillable = ["username", "password"];

	public function roles(){
		/*return $this->hasManyThrough(
			Role::class, UserRole::class,
			"user_id", "id",
			"id", "role_id"
		);*/
		return $this->belongsToMany(Role::class)
		->using(UserRole::class)
//		->as("granted")
		->withTimestamps();
	}

	public function permissions(){
		return $this->roles()->flatMap(function(Role $role){
			return $role->permissions();
		})->uniqueStrict(function(Permission $permission){
			return $permission->id;
		});
	}

	public function admin(){
		return $this->hasOne(Admin::class);
	}

	public function remember(){
		return $this->hasOne(UserRemember::class);
	}

	public function isAdmin(): bool{
		return !is_null($this->admin);
	}

	public function hasRemember(): bool{
		return !is_null($this->remember);
	}

	public function createRemember(?string $id, ?string $token): bool{
		$ret = false;
		if(!$this->hasRemember()) {
			$ret = !!UserRemember::make($this, $id, $token);
			$this->refresh();
		}
		return $ret;
	}

	public function updateRemember(?string $id, ?string $token): bool{
		if(!$this->hasRemember())
			return $this->createRemember($id, $token);
		return $this->remember->updateCredentials($id, $token);
	}

	public function resetRemember(): bool{
		if($this->hasRemember())
			return $this->remember->reset();
		return true;
	}

	/**
	 * Find a user from its username
	 * @param string $username
	 * @return User|null
	 */
	public static function fromUsername(string $username): ?self{
		return self::where("username", $username)->first();
	}

	/**
	 * Create a new user
	 * @param string $username
	 * @param string $passwordHash
	 * @return User
	 * @throws QueryException
	 */
	public static function make(string $username, string $passwordHash): self{
		return self::create([
			"username" => $username,
			"password" => $passwordHash
		]);
	}

}