<?php

namespace App\Http\Controllers\Traits;

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
}
