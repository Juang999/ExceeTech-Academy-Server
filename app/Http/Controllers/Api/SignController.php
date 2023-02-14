<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\{Auth, DB, Hash};
use App\Http\Controllers\Traits\Tools;

class SignController extends Controller
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

    public function logout(Request $request)
    {
        try {
            $user = Auth::user()->token();

            $user->revoke();

            return $this->response('success', 'success to logout', true, 200);

        } catch (\Throwable $th) {
            return $this->response('failed', $th->getMessage(), 'error', 400);
        }
    }
}
