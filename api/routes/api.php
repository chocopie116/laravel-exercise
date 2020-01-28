<?php

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

Route::post('/articles', function () {
    return json_encode(['result' => 'ok']);
});
