<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ScanModel::class, function (Faker $faker) {
    return [

        'title'=>$faker->name(),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS))

    ];
});
