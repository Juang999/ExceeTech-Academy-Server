<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
        
    }
}
