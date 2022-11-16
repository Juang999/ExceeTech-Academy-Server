<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Auth, DB, Hash};
use App\Http\Requests\{RegisterRequest, LoginRequest, RegisterFromAdminRequest};
use App\Http\Controllers\Traits\Tools;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use Tools;

    public function index()
    {
        try {
            $data = User::with('roles')->get();

            return $this->response('success', 'success to get data', $data, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get data', $th->getMessage(), 400);
        }
    }

    public function store(RegisterFromAdminRequest $request)
    {
        try {
            $base_number = 62;

            $explode = explode(' ', strtolower($request->username));

            $password = implode('-', $explode);

            $user = User::create([
                'name' => ucwords($request->name),
                'username' => ucwords($request->username),
                'email' => $request->email,
                'phone_number' => (substr(intval($request->phone_number), 0, 2) != $base_number) ? $base_number.substr(intval($request->phone_number), 1) : intval($request->phone_number),
                'email_verified_at' => Carbon::translateTimeString(now()),
                'password' => Hash::make($password)
            ]);

            $user->assignRole($request->role);

            $user->unhash_password = $password;

            return $this->response('success', 'success to create new user', $user, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to create new user', $th->getMessage(), 400);
        }
    }

    public function show($id)
    {
        try {
            $data = User::where('id', $id)->with('roles')->first();

            return $this->response('success', 'success to get detail user', $data, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get detail user', $th->getMessage(), 400);
        }
    }

    public function update(RegisterRequest $request, $id)
    {
        try {
            User::where('id', $id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return $this->response('success', 'success to update user', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to update user', $th->getMessage(), 400);
        }
    }

    public function delete($id)
    {
        //
    }

    public function changeRoleUser(Request $request, $id)
    {
        try {
            $request->validate([
                'role_name' => 'required'
            ]);

            $user = User::find($id);

            $user->removeRole($user->getRoleNames()[0]);

            $user->assignRole($request->role_name);

            return $this->response('success', 'success to update role', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to update role', $th->getMessage(), 400);
        }
    }

    public function banUser($id)
    {
        try {
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
