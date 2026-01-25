<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/article', [AuthorController::class, 'article'])->name('article');
Route::get('/article_editor', [AuthorController::class, 'article_editor'])->name('article_editor');
Route::post('/store_article', [AuthorController::class, 'store_article'])->name('store_article');
Route::post('/edit_article', [AuthorController::class, 'edit_article'])->name('edit_article');



