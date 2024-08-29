<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function generateToken($user)
    {
        $token = $user->createToken('API_TOKEN');
        return $token->plainTextToken;
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:5'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $user = Auth::attempt($request->only('username', 'password'));

        if ($user) {
            $token = $this->generateToken(Auth::user());
            return $this->success(['message' => 'Login success', 'token' => $token], 200);
        } else return $this->failed(['message' => 'Wrong username or password'], 401);
    }

    public function register(Request $request)
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

        $token = $this->generateToken($user);

        return $this->success(['message' => 'Register success', 'token' => $token], 201);
    }

    public function logout(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());

        if (!$token) return $this->notfound(['message' => 'Unauthenticated']);

        $token->delete();

        return $this->success(['message' => 'Logout success'], 200);
    }
}
