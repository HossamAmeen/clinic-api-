<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserModel::class, function (Faker $faker) {
    return [
        'first_name'=>$faker->firstName(),
        'last_name'=>$faker->lastName(),
        'temp_user_name'=>$faker->name(),
        'temp_password'=>$faker->name(),
        'email' => $faker->unique()->safeEmail,
        'img' => $faker->imageUrl(600, 800),
        'user_name'=>$faker->username,
        'password'=>Hash::make($faker->password),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
        'role'=>$faker->randomElement($array = array (1,10,100)),
    ];
});

$factory->define(App\Models\Clinic::class, function (Faker $faker) {
    return [
        'clinic_name'=>$faker->firstName(),
        'clinic_tel'=>$faker->e164PhoneNumber(),
        'facebook' => "https://www.facebook.com/",
        
        'patient_waiting_time_in_minutes' =>$faker->randomDigitNotNull,
       
        'mac_address'=>$faker->username,
        'in_clinic_now'=>$faker->boolean(),
        'client_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
       
    ];
});