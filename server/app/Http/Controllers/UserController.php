<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereLevel('2')->get();

        return $this->success(['users' => $users], 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:5',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required',
            'profile_picture' => 'required|image',
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $request['password'] = Hash::make($request->password);
        $request['date'] = date('Y-m-d');
        $request['level'] = '2';

        $extension = $request->file('profile_picture')->getClientOriginalExtension();
        $profile_picture = time() . '.' . $extension;
        $path = 'public/profile_picture';

        $request->file('profile_picture')->storeAs(
            $path,
            $profile_picture
        );

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'date_of_birth' => $request->date_of_birth,
            'phone_number' => $request->phone_number,
            'date' => $request->date,
            'profile_picture' => 'storage/profile_picture/' . $profile_picture
        ]);

        return $this->success(['message' => 'User successfully created'], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) return $this->notfound(['message' => 'User not found']);

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email|email',
            'password' => 'min:5',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required',
            'profile_picture' => 'image',
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        if ($request->hasFile('profile_picture')) {
            $path = str_replace('storage/', '', $user->image);
            Storage::delete('public/' . $path);


            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = time() . '.' . $extension;
            $path = 'public/profile_picture';

            $request->file('profile_picture')->storeAs(
                $path,
                $profile_picture
            );

            $request['profile_picture'] = 'profile_picture/' . $profile_picture;
        }

        $user->update($request->all());

        return $this->success(['message' => 'User successfully updated'], 201);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) return $this->notfound(['message' => 'User not found']);

        $user->delete();

        return $this->success([], 204);
    }
}
