<?php

use App\Http\Controllers\Project\PlanController;
use App\Http\Controllers\Project\ProductController;
use App\Http\Controllers\Project\RechargeController;
use App\Http\Controllers\Project\ServicesController;
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
    return view('welcome');
});
Route::prefix('system-setup')->group(function () {

    Route::prefix('services')->group(function () {
        Route::get('/', [ServicesController::class, 'index'])->name('service');
        Route::get('/fetch', [ServicesController::class, 'fetchServices'])->name('service.fetch');
        Route::post('/store', [ServicesController::class, 'store'])->name('service.store');
        Route::get('/edit/{service}', [ServicesController::class, 'editService'])->name('service.edit');
        Route::post('/update/{service}', [ServicesController::class, 'updateService'])->name('service.update');
        Route::post('/delete/{service}', [ServicesController::class, 'deleteService'])->name('service.delete');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/fetch', [ProductController::class, 'fetchProducts'])->name('product.fetch');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{product}', [ProductController::class, 'editProduct'])->name('product.edit');
        Route::post('/update/{product}', [ProductController::class, 'updateProduct'])->name('product.update');
        Route::post('/delete/{product}', [ProductController::class, 'deleteProduct'])->name('product.delete');
    });
    Route::prefix('plans-subscription')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('plan');
        Route::get('/fetch', [PlanController::class, 'fetchPlan'])->name('plan.fetch');
        Route::get('/fetch/product/{service}', [PlanController::class, 'fetchProduct'])->name('plan.fetch.product');
        Route::post('/store', [PlanController::class, 'store'])->name('plan.store');
        Route::get('/edit/{plan}', [PlanController::class, 'editPlan'])->name('plan.edit');
        Route::post('/update/{plan}', [PlanController::class, 'updatePlan'])->name('plan.update');
        Route::post('/delete/{plan}', [PlanController::class, 'deletePlan'])->name('plan.delete');
    });

});
Route::prefix('recharge')->group(function () {
    Route::get('/', [RechargeController::class, 'index'])->name('recharge');
    Route::get('/fetch-transactions', [RechargeController::class, 'fetchTransactions'])->name('recharge.fetch.transactions');
    Route::get('/fetch/{product}', [RechargeController::class, 'fetchPlan'])->name('recharge.fetch.plan');
    Route::get('/fetch/price/{plan}', [RechargeController::class, 'fetchPrice'])->name('recharge.fetch.price');
    Route::post('/store', [RechargeController::class, 'store'])->name('recharge.store');

});


