<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produs;
use Faker\Generator as Faker;

$factory->define(Produs::class, function (Faker $faker) {
    return [
        'nume' => $faker->word,
        'pret' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 500),
        'cantitate' => $faker->numberBetween(5 ,100),
        'descriere' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
