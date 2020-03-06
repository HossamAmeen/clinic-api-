<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\CityModel::class, function (Faker $faker) {
    return [
        'ar_title'=>$faker->name(),
		'en_title'=>$faker->name(),
		'country_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_COUNTRY)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
        ];
});
