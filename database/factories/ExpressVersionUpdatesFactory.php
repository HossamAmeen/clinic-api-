<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ExpressVersionUpdatesModel::class, function (Faker $faker) {
    return [

        'title'=>$faker->name(),
        'url'=>$faker->url(),
        'type'=>$faker->name(),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),

    ];
});
