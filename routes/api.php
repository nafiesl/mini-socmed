<?php

Route::group(['middleware' => 'auth:api', 'as' => 'api.'], function () {
    /**
     * Friendship Routes
     */
    Route::get('friendships/check/{userId}/{friendId}', 'FriendshipsController@check')->name('friendships.check');
    Route::post('friendships/request/{userId}/{friendId}', 'FriendshipsController@request')->name('friendships.request');
    Route::post('friendships/accept/{userId}/{friendId}', 'FriendshipsController@accept')->name('friendships.accept');
    Route::post('friendships/remove/{userId}/{friendId}', 'FriendshipsController@remove')->name('friendships.remove');

    /**
     * Post Routes
     */
    Route::resource('posts', 'Api\PostsController', ['except' => ['show', 'edit']]);

    /**
     * Like Routes
     */
    Route::post('like/{post}', 'Api\LikesController@like');
    Route::post('unlike/{post}', 'Api\LikesController@unlike');
});
