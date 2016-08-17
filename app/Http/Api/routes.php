<?php

/**************************************************************************
 * Comments
 *************************************************************************/
$api->group(['middleware' => 'auth'], function($api) {
    $api->get('comments', [
        'as' => 'comments.list',
        'uses' => 'CommentsController@index'
    ]);

    $api->get('comment/{id}', [
        'as' => 'comments.show',
        'uses' => 'CommentsController@show'
    ]);

    $api->post('comment/write', [
        'as' => 'comments.write',
        'uses' => 'CommentsController@create'
    ]);

    $api->delete('comment/{id}', [
        'as' => 'comments.delete',
        'uses' => 'CommentsController@delete'
    ]);
});
/**************************************************************************
 * Likes
 *************************************************************************/
$api->get('likes', [
    'as' => 'likes.list',
    'uses' => 'LikesController@index'
]);

$api->post('like', [
    'as' => 'likes.like',
    'uses' => 'LikesController@likeOrDislike'
]);

/**************************************************************************
 * Users
 *************************************************************************/
$api->group(['middleware' => 'auth'], function($api) {
    $api->get('me', [
        'as' => 'user.profile',
        'uses' => 'UserController@show'
    ]);
});

$api->get('users', [
    'as' => 'users.list',
    'uses' => 'UserController@index'
]);

$api->get('user/{id}', [
    'as' => 'users.show',
    'uses' => 'UserController@show'
]);

/**************************************************************************
 * Notifications
 *************************************************************************/
$api->group(['middleware' => 'auth'], function($api) {

    $api->get('notifications', [
        'as' => 'notifications.recent',
        'uses' => 'NotificationsController@recent'
    ]);

    $api->put('notifications/read', [
        'as' => 'notifications.read',
        'uses' => 'NotificationsController@markAsRead'
    ]);

});

/**************************************************************************
 * Settings
 *************************************************************************/
$api->get('settings.js', [
    'uses' => 'SettingsController@json'
]);