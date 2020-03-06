<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\DrugModel::class, function (Faker $faker) {
    return [
        'title'=>$faker->name(),
        'is_verified'=>$faker->randomElement($array = array (0,1)),
         'town_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_TOWN)),
		'client_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CLIENTS)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS))

    ];
});
