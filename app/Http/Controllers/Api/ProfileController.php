<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\Tools;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;

class ProfileController extends Controller
{
    use Tools;

    public function detailProfile()
    {
        try {
            $data = Auth::user();
            $data->roles;

            return $this->response('success', 'success to get profile', $data, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get profile', $th->getMessage(), 400);
        }
    }

    public function updateProfile(RegisterRequest $request)
    {
        try {
            User::where('id', Auth::user()->id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return $this->response('success', 'success to update profile', true, 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to update profile', $th->getMessage(), 400);
        }
    }

    public function uploadImage(UploadImageRequest $request) {
        try {
            dd($request->file('photo'));
        } catch (Exception $e) {
            
        }
    }
}
