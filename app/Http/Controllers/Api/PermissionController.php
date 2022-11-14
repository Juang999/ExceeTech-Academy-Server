<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Traits\Tools;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
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
            $permissions = Permission::orderBy('id')->get(['id', 'name']);

            return $this->response('success', 'success to get permission', $permissions, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get permissions', $th->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            $permission = Permission::findById($id, 'api');
            $permission->roles;
            $permission->users = User::whereIn('id', function ($query) use ($permission) {
                $query->select('model_id')
                    ->from('model_has_roles')
                    ->where('model_type', '=', 'App\Models\User')
                    ->whereIn('role_id', function ($query) use ($permission) {
                        $query->select('id')
                            ->from('roles')
                            ->whereIn('name', $permission->roles->pluck('name'))
                            ->get();
                    })->get();
            })->get();

            return $this->response('succes', 'success to get detail pemission', $permission, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get detail permission', $th->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            DB::table('permissions')->where([
                ['id', '=', $id],
                ['guard_name', '=', 'api']
            ])->update([
                'name' => $request->name
            ]);

            return $this->response('success', 'success to update permission', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to update permission', $th->getMessage(), 400);
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
