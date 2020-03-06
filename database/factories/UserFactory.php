<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserModel::class, function (Faker $faker) {
    return [
        'first_name'=>$faker->firstName(),
        'last_name'=>$faker->lastName(),
        'temp_user_name'=>$faker->name(),
        'temp_password'=>$faker->name(),
        'email' => $faker->unique()->safeEmail,
        'img' => $faker->imageUrl(600, 800),
        'user_name'=>$faker->username,
        'password'=>Hash::make($faker->password),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
        'role'=>$faker->randomElement($array = array (1,10,100)),
    ];
});