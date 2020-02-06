<?php

Route::get('/articles', 'Api\ArticleController@index');
Route::get('/articles/{id}', 'Api\ArticleController@show');
Route::post('/articles', 'Api\ArticleController@create');

Route::get('/hashtags', 'Api\HashtagController@index');
Route::get('/hashtags/{id}', 'Api\HashtagController@show');
Route::post('/hashtags', 'Api\HashtagController@create');

Route::get('/hashtags/{hashtag_id}/articles', 'Api\HashtagArticleController@index');

Route::post('/images', 'Api\ImageController@create');
Route::post('/users', 'Api\UserController@create');

Route::post('/sessions', 'Api\SessionController@create');
