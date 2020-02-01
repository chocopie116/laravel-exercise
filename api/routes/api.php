<?php

Route::get('/articles', 'Api\ArticleController@index');
Route::get('/articles/{id}', 'Api\ArticleController@show');
Route::post('/articles', 'Api\ArticleController@create');


Route::get('/hashtags', 'Api\HashtagController@index');
Route::get('/hashtags/{id}', 'Api\HashtagController@show');
Route::post('/hashtags', 'Api\HashtagController@create');
