<?php

use App\User;
use Carbon\Carbon;
use Plank\Mediable\Media;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'api_token' => str_random(10),
        'description' => $faker->sentence(4),
        'type' => 'user',
        'confirmed_at' => null,
        'suspended_at' => null
    ];
});

$factory->state(User::class, 'confirmed', [
    'confirmed_at' => Carbon::now()->toDateTimeString()
]);

$factory->state(User::class, 'suspended', [
    'suspended_at' => Carbon::now()->toDateTimeString()
]);

$factory->afterCreating(User::class, function ($user, $faker) {
    $media = factory(Media::class)->create([
        'disk' => 'local'
    ]);

    $user->syncMedia($media, 'profile_picture');

    $media = factory(Media::class)->create([
        'disk' => 'local'
    ]);
    $user->syncMedia($media, 'cover');
});
