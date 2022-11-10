<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\{Str, Facades\Password, Facades\Hash};

class VerifyController extends Controller
{
    public function notVerified()
    {
        return view('verify.verify');
    }

    public function verify(EmailVerificationRequest $request)
    {
        try {
            $request->fulfill();

            return response()->json([
                'status' => 'success',
                'message' => 'account verified'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => 'account rejected'
            ], 200);
        }
    }

    public function hasVerifiedEmail()
    {
        return view('verify.verified');
    }

    public function getResetPasswordPage($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(66));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? view('auth.changed', ['message' => 'success to reset password'])
                    : view('auth.changed', ['message' => 'failed to reset password']);
    }
}
