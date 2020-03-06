<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\RayModel::class, function (Faker $faker) {
    return [
        'title'=>$faker->name(),
        'is_verified'=>$faker->randomElement($array = array (0,1)),
        'client_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CLIENTS)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS))

	];
});
