<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;

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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/check-user', [LoginController::class, 'check_user'])->name('check-user');

Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/article', [AuthorController::class, 'article'])->name('article');
Route::get('/article_editor', [AuthorController::class, 'article_editor'])->name('article_editor');
Route::post('/store_article', [AuthorController::class, 'store_article'])->name('store_article');
Route::post('/edit_article', [AuthorController::class, 'edit_article'])->name('edit_article');
Route::post('/delete_article', [AuthorController::class, 'delete_article'])->name('delete_article');

Route::get('/article/detail/{id}', [AuthorController::class, 'show_detail_article'])->name('/article/detail/{id}');




