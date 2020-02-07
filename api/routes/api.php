<?php

use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;

Route::get('/articles', 'Api\ArticleController@index');
Route::get('/articles/{id}', 'Api\ArticleController@show');

Route::group(['middleware' => [CheckLogin::class]], function () {
    Route::post('/articles', 'Api\MyArticleController@create');
    Route::get('/users/me/articles', 'Api\MyArticleController@mine');

    Route::delete('/sessions', 'Api\SessionController@destroy');
});

Route::get('/users/{userId}/articles', 'Api\ArticleController@someones');

Route::get('/hashtags', 'Api\HashtagController@index');
Route::get('/hashtags/{id}', 'Api\HashtagController@show');
Route::post('/hashtags', 'Api\HashtagController@create');

Route::get('/hashtags/{hashtag_id}/articles', 'Api\HashtagArticleController@index');

Route::post('/images', 'Api\ImageController@create');
Route::post('/users', 'Api\UserController@create');

Route::post('/sessions', 'Api\SessionController@create');
