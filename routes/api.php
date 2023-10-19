<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("/login", [AuthController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum", 'authApi']], function () {
    Route::get("/me", [AuthController::class, "me"]);
    Route::post("/logout", [AuthController::class, "logout"]);
});

Route::group(["middleware" => ["auth:sanctum", 'authApi:admin']], function () {
    Route::apiResource("/posts", PostController::class);
    Route::post("/posts/image", [PostController::class, "uploadImage"]);
});

Route::group(["middleware" => ["auth:sanctum", 'authApi:sales']], function () {
    Route::get("/sales", fn() => ["message" => "Sales"]);
});

Route::group(["middleware" => ["auth:sanctum", 'authApi:teknisi']], function () {
    Route::get("/teknisi", fn() => ["message" => "teknisi"]);
});

