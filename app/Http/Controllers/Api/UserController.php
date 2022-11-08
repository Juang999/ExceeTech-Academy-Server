<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Auth, DB, Hash};
use App\Http\Requests\{RegisterRequest, LoginRequest};

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where("email", $credentials["email"])->first();

            $token = $user->createToken('Login Token')->accessToken;

            return response()->json([
                'token' => $token
            ], 200);
        }

        return response()->json('email or password icorrect!', 400);
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

            DB::commit();

            $user = User::where("email", $user->email)->first();

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
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
