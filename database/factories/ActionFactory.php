<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Action;
use Illuminate\Support\Str;
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

$factory->define(Action::class, function (Faker $faker) {
    return [
        'title' => Str::random(10),
        'date_start' => $faker->dateTimeBetween('-30 days', 'now'),
        'date_end' => $faker->dateTimeBetween('now', '+60 days')
    ];
});
