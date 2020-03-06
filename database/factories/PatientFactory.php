<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\PatientModel::class, function (Faker $faker) {
    return [
        'full_name'=>$faker->name,
        'address'=>$faker->sentence(1),
        'email'=>$faker->email,
        'tel'=>$faker->randomNumber,
        'social_status'=>$faker->firstName(),
        'ssn'=>$faker->randomNumber,
        'gender'=>$faker->randomElement($array = array (0,1)),
        'client_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CLIENTS)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS))
    ];
});
