<?php

use Laravel\Socialite\Two\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
    return ['Laravel' => app()->version()];
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')
        ->scopes(['read:user', 'public_repo'])
        ->redirect();
})->name('oauth.redirect');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    // All providers...
    dd($user->getId(), $user->getNickname(), $user->getName(), $user->getEmail(), $user->getAvatar());
})->name('oauth.callback');

require __DIR__ . '/auth.php';
