<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Session;
use App\User;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'token' => $faker->unique()->password, //パスワードじゃないけど一旦それっぽいものを
    ];
});
