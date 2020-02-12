<?php

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'content' => $faker->paragraph(),
        'user_id' => 1,
        'draft' => false,
        'header_image_url' => 'https://example.com/path/to/image.png'
    ];
});
