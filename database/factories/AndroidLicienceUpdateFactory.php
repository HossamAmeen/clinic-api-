<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\AndroidLicenceUpdateModel::class, function (Faker $faker) {
    return [
        
        'start_on'=>$faker->date(),
        'end_on'=>$faker->date(),
        'android_licence_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_ANDROID_LICENCES)),
        'user_id'=>$faker->randomElement($array = range (1,\App\Helpers\SeedingHelper::NO_OF_USERS)),
        ];
});
