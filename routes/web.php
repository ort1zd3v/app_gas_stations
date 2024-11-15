<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

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

require __DIR__.'/auth.php';
require __DIR__.'/web/permissions.php';
require __DIR__.'/web/themes.php';

Route::middleware('auth')->group(function () {
	Route::get('/', [HomeController::class, 'index'])->name('home');
	Route::middleware('permissions')->group(function () {
		Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard.index');
	});
});

