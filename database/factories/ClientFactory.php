<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'nume' => $faker->company,
        'nr_ord_reg_com' => $faker->numberBetween(100000000000, 999999999999),
        'cui' => $faker->numberBetween(100000000000, 999999999999),
        'adresa' => $faker->streetAddress,
        'iban' => $faker->bankAccountNumber,
        'banca' => $faker->company,
        'reprezentant' => $faker->name,
        'reprezentant_functie' => $faker->jobTitle,
        'telefon' => $faker->phoneNumber,
        'email' => $faker->freeEmail,
        // 'pret' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 500),
        // 'cantitate' => $faker->numberBetween(5 ,100),
        // 'cod_de_bare' => $faker->numberBetween(100000000000, 999999999999),
        // 'descriere' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
