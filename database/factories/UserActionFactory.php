<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User_action;
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

$factory->define(User_action::class, function (Faker $faker) {
    $usersIDs = DB::table('users')->pluck('id');
    $actionsIDs = DB::table('actions')->pluck('id');

    return [
        'user_id' => $faker->randomElement($usersIDs),
        'action_id' => $faker->randomElement($actionsIDs)
    ];
});
