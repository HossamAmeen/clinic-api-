<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\SpecialistModel::class, function (Faker $faker) {
    return [
        'ar_title'=>$faker->name(),
		'en_title'=>$faker->name(),
		'user_id'=>1,
        ];
});
