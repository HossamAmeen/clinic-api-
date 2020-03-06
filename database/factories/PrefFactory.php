<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\PrefModel::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>$faker->sentence(),
        'email'=>'info@u-clinics.com',
        'call_center'=>'01022036171 - 01022036171',
        'sales_tel'=>'01022036171 - 01022036171',
        'address'=>'أبراج النصر برج ج2 الدور الثاني علوي - أسيوط - مصر',
        'facebook'=>$faker->url(),
        'android_download_link'=>$faker->url(),
		'user_id'=>1
    ];
});
