<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\LigneCommandeController;
use App\Http\Controllers\LigneMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refreshToken', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::get('users/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');

// Routes protégées par auth:api
// Routes protégées (nécessitent une authentification)
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('all-users',[AuthController::class,'allusers']);
    Route::resource('categories', CategorieController::class);
    Route::resource('articles', ArticleController::class);
    Route::resource('commandes', CommandeController::class);
    // Route::get('/commandes/last-id', [CommandeController::class,'getLastCommandeId']);
    Route::resource('lignescommandes', LigneCommandeController::class);
    Route::resource('menus', MenuController::class);
    // Route::get('menus/menuspaginate', [MenuController::class,'menusPaginate']);
    Route::resource('lignesmenus', LigneMenuController::class);
    Route::post('/payment/processpayment', [StripeController::class,
'processPayment']);
});


