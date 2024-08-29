<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function validateRes($errors) {
        return response()->json(['message' => 'Invalid field', 'errors' => $errors], 422);
    }

    public function success($data, $code) {
        return response()->json($data, $code);
    }

    public function failed($data, $code) {
        return response()->json($data, $code);
    }
}
