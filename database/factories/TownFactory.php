<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\TownModel::class, function (Faker $faker) {
    return [
        'ar_title'=>$faker->name(),
		'en_title'=>$faker->name(),
		'city_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CITY)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
        ];
});
