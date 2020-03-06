<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\RadiologyLabModel::class, function (Faker $faker) {
    return [
        'title'=>$faker->name(),
        'address'=>$faker->streetAddress,
        'tel'=>$faker->randomNumber,
        'town_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_TOWN)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
    ];
});
