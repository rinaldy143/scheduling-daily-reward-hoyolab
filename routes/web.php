<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CookiesController;
use App\Http\Controllers\HoyolabController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
});
Route::get('/supabase/fetch-users', [HoyolabController::class, 'fetchUsers'])->name('fetchUsers');
Route::get('/run-script', [HoyolabController::class, 'runNodeScript'])->name('runNodeScript');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [HoyolabController::class, 'index'])->name('home');
Route::get('/cookies', [CookiesController::class, 'index'])->name('cookies.index');
Route::post('/cookies/update', [CookiesController::class, 'update'])->name('cookies.update');
Route::post('/cookies/store', [CookiesController::class, 'store'])->name('cookies.store');
Route::get('/cron', [CookiesController::class, 'handle']);




