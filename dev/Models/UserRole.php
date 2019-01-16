<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot {
	protected $table = "user_roles";
}