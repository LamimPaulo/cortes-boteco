<?php

use App\Http\Controllers\Auth\PassportAuthController;
use App\Http\Controllers\CortesController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});
Route::get('/register', function () {
    // if(Auth::check()) {
    //     return redirect()->route('dashboard');
    // }
    return view('auth.register');
});


Route::post('/login', [PassportAuthController::class, 'webLogin'])->name('login');
Route::post('/signup', [PassportAuthController::class, 'webRegister'])->name('signup');

Route::group((['middleware' => ['auth:web']]), function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/upload', [CortesController::class, 'chunkStore'])->name('corte.upload');
});
