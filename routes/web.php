<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
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

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::redirect('/dashboard','/dashboard/orders')->middleware(['auth'])->name('dashboard');

Route::group(['prefix'=>'dashboard', 'middleware' => ['auth']], function () {
    Route::resource('orders', OrderController::class);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('produits/{item:slug}', [ItemController::class, 'show'])->name('items.show');
Route::get('produits/{item:slug}/checkout', [ItemController::class, 'checkout'])->name('items.checkout');
Route::resource('books', BookController::class);
Route::resource('companies', CompanyController::class);
Route::match(['get','post'],'payments/test', [PaymentController::class,'test'])->name('payments.test');

Route::resource('payments', PaymentController::class);


Route::post('git-deploy', function () {
    Artisan::call('git:deploy');
    return response()->json(['message' => 'Deployed']);
});

require __DIR__ . '/auth.php';
