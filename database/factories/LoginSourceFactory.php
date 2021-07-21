<?php

use App\Login_source;
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

$factory->define(Login_source::class, function (Faker $faker) {
    $usersIDs = DB::table('users')->pluck('id');

    return [
        'user_id' => $faker->randomElement($usersIDs),
        'tms' => $faker->dateTimeBetween('-30 days', '+60 days'),
        'source' => $faker->randomElement(['site', 'android', 'iphone'])
    ];
});
