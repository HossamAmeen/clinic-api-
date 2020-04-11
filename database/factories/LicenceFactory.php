<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\LicenceModel::class, function (Faker $faker) {
    $someDate = $faker->date();
    $nextYear =  date('Y-m-d', strtotime("+12 months $someDate"));


    return [
        'start_on'=>$someDate,
        'end_on'=>$nextYear,
        'clinic_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CLIENTS)),
		'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),

    ];
});
