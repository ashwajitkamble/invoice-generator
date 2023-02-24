<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
// Softdelete table row
Route::get('/dashboard/{id}/{model}', [App\Http\Controllers\Controller::class, 'delete'])->name('delete.submit');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
// invoice routes
Route::get('/invoice', [App\Http\Controllers\InvoiceListController::class, 'index'])->name('invoice')->middleware('can:invoice');
Route::get('/invoice-add', [App\Http\Controllers\InvoiceListController::class, 'add'])->name('invoice-add')->middleware('can:invoice-add');
Route::match(['get', 'post'], '/invoice-edit/{id?}',[App\Http\Controllers\InvoiceListController::class, 'add'])->name('invoice-edit')->middleware('can:invoice-edit');
// Users routes
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('can:user');
Route::get('/user-add', [App\Http\Controllers\UserController::class, 'add'])->name('user-add')->middleware('can:user-add');
Route::match(['get', 'post'], '/user-edit/{id?}',[App\Http\Controllers\UserController::class, 'add'])->name('user-edit')->middleware('can:user-edit');
//estimates routes
Route::get('/estimate', [App\Http\Controllers\EstimateController::class, 'index'])->name('estimate')->middleware('can:estimate');
Route::get('/estimate-add', [App\Http\Controllers\EstimateController::class, 'add'])->name('estimate-add')->middleware('can:estimate-add');
Route::match(['get', 'post'], '/estimate-edit/{id?}',[App\Http\Controllers\EstimateController::class, 'add'])->name('estimate-edit')->middleware('can:estimate-edit');
// roles and permissions routes

Route::get('/role', [App\Http\Controllers\RoleController::class, 'index'])->name('role')->middleware('can:role');
Route::get('/role-add', [App\Http\Controllers\RoleController::class, 'add'])->name('role-add')->middleware('can:role-add');
Route::match(['get', 'post'], '/role-edit/{id?}',[App\Http\Controllers\RoleController::class, 'add'])->name('role-edit')->middleware('can:role-edit');
//profile
Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
//seller
Route::get('/seller', [App\Http\Controllers\SellerController::class, 'index'])->name('seller')->middleware('can:seller');
Route::get('/seller-add', [App\Http\Controllers\SellerController::class, 'add'])->name('seller-add')->middleware('can:seller-add');
Route::match(['get', 'post'], '/seller-edit/{id?}',[App\Http\Controllers\SellerController::class, 'add'])->name('seller-edit')->middleware('can:seller-edit');
//view and download estimates
Route::match(['get', 'post'], '/invoice-view/{id?}',[App\Http\Controllers\InvoiceListController::class, 'generateInvoice'])->name('invoice-view');
Route::match(['get', 'post'], '/invoice-download/{id?}',[App\Http\Controllers\InvoiceListController::class, 'downloadInvoice'])->name('invoice-download');

//Estimate
Route::match(['get', 'post'], '/estimate-view/{id?}',[App\Http\Controllers\EstimateController::class, 'generateEstimate'])->name('estimate-view');
Route::match(['get', 'post'], '/estimate-download/{id?}',[App\Http\Controllers\EstimateController::class, 'downloadEstimate'])->name('estimate-download');


