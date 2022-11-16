<?php

namespace App\Http\Controllers\Traits;

use App\Http\Controllers\response;
use Spatie\Permission\Models\Role;

/**
 *
 */
trait Tools
{
    public function response($status = 'success', $message = 'success', $result = true, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'result' => $result
        ], $code);
    }

    public function createRole($roleName)
    {
        $role = Role::create([
            'name' => $roleName,
            'guard_name' => 'api'
        ]);

        return $role;
    }

    public function permission($roleName, $permission)
    {
        $role = Role::findByName($roleName[0], 'api');
        $boolean = $role->hasPermissionTo($permission);
        if ($boolean == false) {
            return $boolean;
        } else {
            return $boolean;
        }
    }
}
