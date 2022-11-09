<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\response;

class VerificationController extends Controller
{
    public $responseJson;

    public function __construct()
    {
        $this->responseJson = new response;
    }

    public function notVerified()
    {
        return response()->json([
            'status' => 'rejected',
            'message' => 'your account is not verified'
        ], 300);
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

    public function resendEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'message' => 'resend email'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? $this->responseJson->response('success', 'success to send forgot password link', true, 200)
                : $this->responseJson->response('failed', 'failed to send forgot password link', false, 400);
    }
}
