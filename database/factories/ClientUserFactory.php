<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ClientUserModel::class, function (Faker $faker) {
    return [
        'client_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CLIENTS)),

        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
        'client_pk_value'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CLIENTS)),
    ];
});