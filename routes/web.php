<?php

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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UsersController@index')->name('users.index');
Route::get('/users/{user}', 'UsersController@show')->name('users.show');

Route::get('friendships/check/{userId}/{friendId}', 'FriendshipsController@check')->name('friendships.check');
Route::post('friendships/request/{userId}/{friendId}', 'FriendshipsController@request')->name('friendships.request');
Route::post('friendships/accept/{userId}/{friendId}', 'FriendshipsController@accept')->name('friendships.accept');
Route::post('friendships/remove/{userId}/{friendId}', 'FriendshipsController@remove')->name('friendships.remove');

Route::get('/notifications', 'NotificationsController@index')->name('notifications.index');
Route::get('/notifications/unread', 'NotificationsController@unread')->name('notifications.unread');
