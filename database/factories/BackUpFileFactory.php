<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\BackUpFileModel::class, function (Faker $faker) {
    return [
           'no_of_using'=>$faker->randomElement($array = range (1,10)),
           'url'=>$faker->url(),
            'backup_licence_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_LICENCES)),
            'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),

    ];
});
