<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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
    return view('welcome');
});

Route::prefix('tests')->name('test')->group(function () {
    Route::get('/', [TestController::class, 'index']);
    Route::get('create', [TestController::class, 'create'])->name('.create');
    Route::post('store', [TestController::class, 'store'])->name('.store');
    Route::get('{test}', [TestController::class, 'edit'])->name('.edit');
    Route::put('{test}', [TestController::class, 'update'])->name('.update');
    Route::delete('{id}', [TestController::class, 'delete'])
        ->name('.delete')
        ->whereNumber('id');
});
