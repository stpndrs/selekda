<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogCommentsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout')->middleware('admin');
    });
    Route::prefix('user')->middleware('auth:sanctum')->controller(ProfileController::class)->group(function () {
        Route::get('profile', 'index');
        Route::put('profile', 'update');
    });
    Route::prefix('blog')->group(function () {
        Route::prefix('comments')->middleware('auth:sanctum')->controller(BlogCommentsController::class)->group(function () {
            Route::get('/{blog_id}', 'index');
            Route::post('/{blog_id}', 'store');
            Route::put('/{blog_id}/{id}', 'update');
            Route::delete('/{blog_id}/{id}', 'delete');
        });
    });
    Route::prefix('captcha')->controller(CaptchaController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/verification', 'verification');
    });
    Route::middleware('admin')->group(function() {
        Route::resource('banner', BannerController::class);
        Route::resource('blog', BlogController::class);
        Route::resource('portfolio', PortfolioController::class);
        Route::resource('user', UserController::class);
    });
});
