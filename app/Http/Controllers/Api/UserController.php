<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Traits\Tools;
use App\Http\Requests\UploadImageRequest;
use Illuminate\Support\Facades\{Auth, DB, Hash, File, Storage};
use App\Http\Requests\{RegisterRequest, RegisterFromAdminRequest, UpdateProfileRequest};

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

    public function detailProfile()
    {
        try {
            $user = Auth::user();

            $role = $user->getRoleNames();

            return $this->response('success', 'success to get profile', compact('user', 'role'), 200);
        } catch (\Throwable $th) {
            return $this->response('failed', 'failed to get profile', $th->getMessage(). 400);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = User::find(Auth::user()->id);

            $updateProfile = $user->update([
                "name" => ($request->name) ? $request->name : $user->name,
                "username" => ($request->username) ? $request->username : $user->username,
                "email" => ($request->email) ? $request->email : $user->email,
                "phone_number" => ($request->phone_number) ? $request->phone_number : $user->phone_number
            ]);

            return $this->response('success', 'success to update profile', $updateProfile, 200);
        } catch (\Throwable $th) {
            return $this->response("failed", "failed to update profile", $th->getMessage(), 400);
        }
    }

    public function uploadImage(UploadImageRequest $request) {
        try {
            $image = $request->file('image');
            $user = Auth::user();
            $filename = $image->getClientOriginalName();

            $image->storeAs("public/profile", $filename, 'local');

            User::where([
                'id' => $user->id
            ])->update([
                'photo' => "profile/$filename"
            ]);

            return $this->response('success', 'success to upload image', true, 200);
        } catch (Exception $e) {
            return $this->response('failed', 'failed to upload image', $e->getMessage(), 400);
        }
    }
}
