<?php


use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ])->name('home');
});

Route::get('/dashboard',function (){
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('git-deploy', function () {
    Artisan::call('git:deploy');
    return response()->json(['message' => 'Deployed']);
});

require __DIR__ . '/auth.php';
