<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
    return redirect()->to(route('login'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/category', CategoryController::class)->middleware('user');
Route::resource('/income', IncomeController::class)->middleware('user');
Route::resource('/expense', ExpenseController::class)->middleware('user');
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::resource('/wishlist', WishlistController::class)->middleware('user');
Route::resource('/users', UsersController::class)->middleware('admin');
