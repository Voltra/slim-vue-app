<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot {
	protected $table = "role_permissions";
}