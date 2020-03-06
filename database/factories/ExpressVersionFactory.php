<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ExpressVersionModel::class, function (Faker $faker) {
    return [

        'version'=>$faker->name(),
		'file' =>$faker->url(),
		'stable'=>1,
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),

    ];
});
