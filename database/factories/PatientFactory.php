<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\PatientModel::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'address' => $faker->sentence(1),
        'email' => $faker->email,
        'tel' => $faker->randomNumber,
        'social_status' => $faker->firstName(),
        'ssn' => $faker->randomNumber,
        'gender' => $faker->randomElement($array = array(0, 1)),
        'client_id' => $faker->randomElement($array = range(1, \App\Helpers\SeedingHelper::NO_OF_CLIENTS)),
        'user_id' => $faker->randomElement($array = range(1, \App\Helpers\SeedingHelper::NO_OF_USERS)),
    ];
});

$factory->define(\App\Models\VisitType::class, function (Faker $faker) {
    return [


        'title' => $faker->name,
        'expectation_period_in_minutes' => $faker->randomElement(range(2, 50)),
        'is_favourite' => $faker->boolean,
        'fees' => $faker->randomElement(range(2, 50)),
        'period' =>$faker->randomElement(range(2, 50)),
        'clinic_id' => $faker->randomElement($array = range(1, 10)),
        'client_visit_type_id' => $faker->randomElement($array = range(1, 10)),
        'user_id' => $faker->randomElement($array = range(1, 10)),
    ];
});

$factory->define(\App\Models\PatientVisitModel::class, function (Faker $faker) {
    return [

        'initial_diagnose' => $faker->name,
        'fees' => $faker->randomElement(range(2, 50)),
        'consultation_date' => $faker->date,
        'visit_datetime' => $faker->date,
        'appointment_id' => $faker->randomElement($array = range(1, 10)),
        'patient_id' => $faker->randomElement($array = range(1, 10)),
        'client_visit_id' => $faker->randomElement($array = range(1, 10)),
        'user_id' => $faker->randomElement($array = range(1, 10)),
    ];
});
