<?php

use App\User;
use Faker\Generator as Faker;
use Modules\Comments\Entities\Comment;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'model_id' => null,
        'model_type' => null
    ];
});
