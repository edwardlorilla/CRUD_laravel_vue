<?php

use App\Photo;
use App\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::resource('users', 'UsersController');
Route::resource('posts', 'PostsController');

Route::post('users/{user}/edit', 'UsersController@edits')->name('user.edits');
Route::post('user/destroy/{id?}', 'UsersController@destroy')->name('user.destroy');
