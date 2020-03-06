<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\PatientClientModel::class, function (Faker $faker) {
    return [
        'patient_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_PATIENTS)),
        'client_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CLIENTS)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS))
    ];
});
