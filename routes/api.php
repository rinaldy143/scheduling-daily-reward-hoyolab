<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoyolabController;

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

// Route::get('/supabase/fetch-users', [HoyolabController::class, 'fetchUsers'])->name('fetchUsers');
// Route::get('/run-script', [HoyolabController::class, 'runNodeScript'])->name('runNodeScript');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
