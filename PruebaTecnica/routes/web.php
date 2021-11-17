<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
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
// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/transactions', [TransactionController::class, 'index']);
    
    // retornamos direcatamente la vista sin necesidad de un controlador
    Route::get('/transactions/new',function(){
        return view('transactional.new');
    });

    Route::prefix('api')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'list']);
        Route::get('/accounts', [AccountController::class, 'create']);
        Route::get('/accounts/list', [AccountController::class, 'list']);
        Route::post('/transactions', [TransactionController::class, 'create']);
    });
});
