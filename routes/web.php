<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\User;

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
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-store', [LoginController::class, 'register_store'])->name('register_store');



Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/article', [AuthorController::class, 'article'])->name('article');
Route::get('/article_editor', [AuthorController::class, 'article_editor'])->name('article_editor');
Route::post('/store_article', [AuthorController::class, 'store_article'])->name('store_article');
Route::post('/edit_article', [AuthorController::class, 'edit_article'])->name('edit_article');
Route::post('/delete_article', [AuthorController::class, 'delete_article'])->name('delete_article');

Route::get('/level_editor', [LevelController::class, 'level_editor'])->name('level_editor');
Route::post('/store_level', [LevelController::class, 'store_level'])->name('store_level');
Route::post('/edit_level', [LevelController::class, 'edit_level'])->name('edit_level');
Route::post('/delete_level', [LevelController::class, 'delete_level'])->name('delete_level');

Route::get('/user_editor', [UserController::class, 'user_editor'])->name('user_editor');
Route::post('/store_user', [UserController::class, 'store_user'])->name('store_user');
Route::post('/edit_user', [UserController::class, 'edit_user'])->name('edit_user');
Route::post('/delete_user', [UserController::class, 'delete_user'])->name('delete_user');


Route::get('/article/detail/{id}', [AuthorController::class, 'show_detail_article'])->name('/article/detail/{id}');




