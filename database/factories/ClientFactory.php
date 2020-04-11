<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ClientModel::class, function (Faker $faker) {
    return [
      	'client_email'=>$faker->email,
      	'doctor_tel'=>$faker->randomNumber,
        'doctor_full_name'=>$faker->name,
        '__TOKEN' => "",
		    'specialist_id'=>1,
        'town_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_TOWN)),
       // 'city_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CITY)),
       // 'country_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_COUNTRY)),
        'user_id'=>1,
		    'client_user_id'=>1
	];
});
$factory->define(\App\Models\Appointment::class, function (Faker $faker) {
  return [
      'date'=>$faker->date,
      'from_time'=>$faker->time($format = 'H:i:s', $max = 'now'), // '20:49:42',
      'to_time'=>$faker->time($format = 'H:i:s', $max = 'now'),
      'is_online_reservation' => $faker->boolean,
      'visit_type_id'=>$faker->randomElement($array = range (1,10)),
      'patient_id'=>$faker->randomElement($array = range (1,10)),
      'clinic_id' => $faker->randomElement($array = range (1,10)),
     // 'city_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_CITY)),
     // 'country_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_COUNTRY)),
      'user_id'=>$faker->randomElement($array = range (1,10)),
   
];
});