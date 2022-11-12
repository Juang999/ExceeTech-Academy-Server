<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\response;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Auth, DB, Hash};
use App\Http\Requests\{RegisterRequest, LoginRequest};

class UserController extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = new response;
    }

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

            return $this->response->response('success', 'success to get profile', $data, 200);
        } catch (\Throwable $th) {
            return $this->response->response('failed', 'failed to get profile', $th->getMessage(), 400);
        }
    }

    public function registerClient()
    {
        try {

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
