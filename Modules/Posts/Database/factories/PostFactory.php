<?php

use App\User;
use Plank\Mediable\Media;
use Faker\Generator as Faker;
use Modules\Posts\Entities\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'user_id' => function(){
            return factory(User::class)->create()->id;
        }
    ];
});

$factory->afterCreating(Post::class, function($post, $faker){
    $media = factory(Media::class,3)->create();

    $post->syncMedia($media, 'images');
});
