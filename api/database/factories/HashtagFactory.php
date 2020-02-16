<?php

use App\Models\Hashtag;
use Faker\Generator as Faker;

$factory->define(Hashtag::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
    ];
});
