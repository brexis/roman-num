<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Services\RomanConversionService;

$factory->define(App\Roman::class, function (Faker\Generator $faker) {
  $service = new RomanConversionService;
  $number = $faker->numberBetween(1, 3999);
  $result = $service->convert($number);

  return [
    'number' => $number,
    'result' => $result
  ];
});
