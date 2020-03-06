<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ClientModel::class, function (Faker $faker) {
    return [
        'clinic_name'=>$faker->name,
      	'clinic_email'=>$faker->email,
      	'doctor_tel'=>$faker->randomNumber,
        'no_of_patients'=>$faker->randomNumber,
      	'mac_address'=>$faker->randomNumber,
      	'doctor_full_name'=>$faker->name,
		    'specialist_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_SPECIALIST)),
        'town_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_TOWN)),
        'city_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CITY)),
        'country_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_COUNTRY)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
		    'client_user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS))

	];
});
