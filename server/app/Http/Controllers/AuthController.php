<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function generateToken($user) {
        $token = $user->createToken('API_TOKEN');
        return $token->plainTextToken;
    }

    public function login(Request $request) {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $user = Auth::attempt($request->only('username', 'password'));

        if ($user) $token = $this->generateToken($user); return $this->success(['message' => 'Login success', 'token' => $token], 200);
    }

    public function register(Request $request) {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:user,username',
            'email' => 'required|unique:user,email|email',
            'password' => 'required|min:6',
            'date_of_birth' => 'date',
            'phone_number' => 'number',
            'profile_picture' => 'image',
        ]);

        if ($validate->fails()) return $this->validate

        $request['password'] = Hash::make($request->password);
        $request['date'] = date('d-m-Y');
    }
}
