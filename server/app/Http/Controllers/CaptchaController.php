<?php

namespace App\Http\Controllers;

use App\Models\Captcha;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaptchaController extends Controller
{
    public function index(Request $request)
    {
        $captchaKey = Str::random(10);
        $captchaValue = Str::random(6);

        Captcha::create([
            'captcha_key' => $captchaKey,
            'captcha_value' => $captchaValue,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);

        return response()->json([
            'captcha_key' => $captchaKey,
            'captcha' => $captchaValue,
        ]);
    }

    public function verification(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'captcha_key' => 'required',
            'captcha_value' => 'required',
        ]);

        if ($validate->fails()) return $this->validateRes($validate->errors());

        $captcha = Captcha::where('captcha_key', $request->captcha_key)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($captcha && hash_equals($captcha->captcha_value, $request->captcha_value)) {
            return response()->json(['valid' => 'true'], 200);
        }

        return response()->json(['valid' => 'false'], 422);
    }
}
