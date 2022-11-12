<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\Tools;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    use Tools;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $role = Role::orderBy('id')->get(['id', 'name']);

            return $this->response('success', 'success to get role', $role, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get role', $th->getMessage(), 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $role = $this->createRole($request->role_name);

            $permissions = json_decode($request->permissions, true);

                $role->givePermissionTo($permissions);
            DB::commit();

            return $this->response('success', 'success to create role', $role, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->response('failed', 'failed to create role', $th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $role = Role::findById($id, 'api');
            $role['users'] = User::role($role->name)->get();
            $role['permissions'] = $role->permissions;

            return $this->response('success', 'success to get detail role', $role, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get detail role', $th->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            DB::beginTransaction();
                $role = Role::findById($id, 'api');

                if ($request->role_name != NULL) {
                    $role->update(['name' => $request->role_name]);
                }

                if ($request->remove_permission != NULL) {
                    $removePermissions = json_decode($request->remove_permission, true);
                    $role->revokePermissionTo($removePermissions);
                }

                if ($request->add_permission != NULL) {
                    $addPermissions = json_decode($request->add_permission, true);
                    $role->givePermissionTo($addPermissions);
                }

            DB::commit();

            return $this->response('success', 'success to update role', true, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->response('failed', 'failed to update role', $th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
