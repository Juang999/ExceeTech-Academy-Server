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

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
    ]);

        if (Auth::attempt($credentials)) {
            $user = User::where("username", $credentials["username"])->first();

            $token = $user->createToken('Login Token')->accessToken;

            return response()->json([
                'token' => $token
            ], 200);
        }

        return response()->json('username or password icorrect!', 400);
    }

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password)
            ]);

            $user->assignRole('client');

            DB::commit();

            $token = $user->createToken('Login Token')->accessToken;

            event(new Registered($user));
            return response()->json([
                'status' => 'success',
                'message' => 'registration successfully!',
                'data' => $user,
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'registration failure',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    public function profile()
    {
        try {
            $data = Auth::user();

            return $this->response('success', 'success to get profile', $data, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get profile', $th->getMessage(), 400);
        }
    }

    public function registerClient(Request $request)
    {
        $auth = $this->permission(Auth::user()->getRoleNames(), 'create-user');
        if ($auth == false) {
            return $this->response('failed', "your role hasn't permission", false, 300);
        }

        try {
            $base_number = 62;

            $explode = explode(' ', strtolower($request->username));

            $password = implode('-', $explode);

            $user = User::create([
                'name' => ucwords($request->name),
                'username' => ucwords($request->username),
                'email' => $request->email,
                'phone_number' => (substr(intval($request->phone_number), 0, 2) != $base_number) ? $base_number.substr(intval($request->phone_number), 1) : intval($request->phone_number),
                'verified_at' => Carbon::translateTimeString(now()),
                'password' => Hash::make($password)
            ]);

            $user->assignRole($request->role);

            $user->unhash_password = $password;

            return $this->response('success', 'success to create new user', $user, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to create new user', $th->getMessage(), 400);
        }
    }
}
