<?php

Route::get('/articles', 'Api\ArticleController@index');
Route::get('/articles/{id}', 'Api\ArticleController@show');
Route::post('/articles', 'Api\ArticleController@create');
