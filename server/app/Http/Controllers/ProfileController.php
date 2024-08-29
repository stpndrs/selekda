<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $findToken = PersonalAccessToken::findToken($request->bearerToken());
        $user = $findToken->tokenable;

        return $this->success(['items' => $user], 200);
    }

    public function update(Request $request)
    {
        $findToken = PersonalAccessToken::findToken($request->bearerToken());
        $user = $findToken->tokenable;

        if ($request->hasFile('profile_picture')) {
            Storage::delete($user->profile_picture);

            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = time() . '.' . $extension;
            $path = 'public/profile_picture';

            $request->file('profile_picture')->storeAs(
                $path,
                $profile_picture
            );

            $request['profile_picture'] = $path . '/' . $profile_picture;
        }

        $user->update($request->all());

        return $this->success(['message' => 'Update profile success', 'items' => $user], 201);
    }
}
