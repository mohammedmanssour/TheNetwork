<?php

use Faker\Generator as Faker;

$factory->define(Plank\Mediable\Media::class, function (Faker $faker) {
    $types = config('mediable.aggregate_types');
    $type = $faker->randomElement(array_keys($types));
    return [
        'disk' => 'tmp',
        'directory' => implode('/', $faker->words($faker->randomDigit)),
        'filename' => $faker->word,
        'extension' => $faker->randomElement($types[$type]['extensions']),
        'mime_type' => $faker->randomElement($types[$type]['mime_types']),
        'aggregate_type' => $type,
        'size' => $faker->randomNumber(),
    ];
});