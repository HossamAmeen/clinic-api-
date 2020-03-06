<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\AndroidLicenceModel::class, function (Faker $faker) {
    return [

        'start_on'=>$faker->date(),
        'end_on'=>$faker->date(),
        'licence_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_LICENCES)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),

    ];
});
