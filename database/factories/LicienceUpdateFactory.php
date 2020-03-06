<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\LicenceUpdateModel::class, function (Faker $faker) {
    return [
        'from'=>$faker->date(),
        'to'=>$faker->date(),
        'licence_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_LICENCES)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),


    ];
});
