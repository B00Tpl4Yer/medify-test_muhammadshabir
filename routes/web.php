<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index'])->name('master-items.index');
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search'])->name('master-items.search');
Route::get('/master-items/export-excel', [App\Http\Controllers\MasterItemsController::class, 'exportExcel'])->name('master-items.export-excel');
Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);

// Standard CRUD with Route Model Binding
Route::get('/master-items/create', [App\Http\Controllers\MasterItemsController::class, 'create'])->name('master-items.create');
Route::post('/master-items', [App\Http\Controllers\MasterItemsController::class, 'store'])->name('master-items.store');
Route::get('/master-items/{masterItem}', [App\Http\Controllers\MasterItemsController::class, 'show'])->name('master-items.show');
Route::get('/master-items/{masterItem}/edit', [App\Http\Controllers\MasterItemsController::class, 'edit'])->name('master-items.edit');
Route::put('/master-items/{masterItem}', [App\Http\Controllers\MasterItemsController::class, 'update'])->name('master-items.update');
Route::delete('/master-items/{masterItem}', [App\Http\Controllers\MasterItemsController::class, 'destroy'])->name('master-items.destroy');

// Kategori Items
Route::get('/kategori-items', [App\Http\Controllers\KategoriItemsController::class, 'index'])->name('kategori-items.index');
Route::get('/kategori-items/create', [App\Http\Controllers\KategoriItemsController::class, 'create'])->name('kategori-items.create');
Route::post('/kategori-items', [App\Http\Controllers\KategoriItemsController::class, 'store'])->name('kategori-items.store');
Route::get('/kategori-items/{kategoriItem}', [App\Http\Controllers\KategoriItemsController::class, 'show'])->name('kategori-items.show');
Route::get('/kategori-items/{kategoriItem}/edit', [App\Http\Controllers\KategoriItemsController::class, 'edit'])->name('kategori-items.edit');
Route::put('/kategori-items/{kategoriItem}', [App\Http\Controllers\KategoriItemsController::class, 'update'])->name('kategori-items.update');
Route::delete('/kategori-items/{kategoriItem}', [App\Http\Controllers\KategoriItemsController::class, 'destroy'])->name('kategori-items.destroy');
Route::get('/kategori-items/{kategoriItem}/download-pdf', [App\Http\Controllers\KategoriItemsController::class, 'downloadPdf'])->name('kategori-items.download-pdf');
