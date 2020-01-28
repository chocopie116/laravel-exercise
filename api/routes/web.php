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
    return json_encode(['message' => 'hello world']);
});



Route::get('/articles', function () {
    $entries = [
        [
            'id' => 1,
            'title' => 'this is title',
            'body' => 'this is article main content.'
        ],
        [
            'id' => 2,
            'title' => 'this is title',
            'body' => 'this is article main content.'
        ]
    ];
    return json_encode($entries);
});


Route::get('/articles/{id}', function () {
    $entries = [
            'id' => 1,
            'title' => 'this is title',
            'body' => 'this is article main content.'
    ];

    return json_encode($entries);
});
