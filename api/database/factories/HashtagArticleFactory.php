<?php

use App\Models\Article;
use App\Models\Hashtag;
use App\Models\HashtagArticle;
use Faker\Generator as Faker;

$factory->define(HashtagArticle::class, function (Faker $faker) {
    return [
        'article_id' => function () {
            return factory(Article::class)->create()->id;
        },
        'hashtag_id' => function () {
            return factory(Hashtag::class)->create()->id;
        }
    ];
});
