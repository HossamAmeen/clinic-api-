<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\ExternalLinksModel::class, function (Faker $faker) {
    return [
        'zedy_url'=>substr($faker->url(),60),
        'whatsapp_url'=>substr($faker->url(),60),
        'site_url'=>substr($faker->url(),60),
        'u_clinics_facebook_url'=>substr($faker->url(),60),
        'social_media_services_url'=>substr($faker->url(),60),
        'branding_services_url'=>substr($faker->url(),60),
        'video_services_url'=>substr($faker->url(),60),
        'mobile_services_url'=>substr($faker->url(),60),
        'sites_services_url'=>substr($faker->url(),60),
        'printing_services_url'=>substr($faker->url(),60),
		'user_id'=>1
    ];
});

