<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        App\Models\UserModel::create(['first_name' => 'abd',
            'last_name'=> 'abdelrahman',
            'user_name' => 'elzedy',
            'password'=>bcrypt('admin'),
            'role'=>'1',
            'active'=>'1',
            'email'=>'info@u-clinics.com',
            'img'=>\App\Models\UserModel::MALE_LOGO
        ]);
        App\Models\PrefModel::create([
        'name'=> 'asd',
        'user_id' => 1
    ]);

//        factory(App\Models\UserModel::class,\App\Helpers\SeedingHelper::NO_OF_USERS)->create();
//        $this->command->info('Creating sample users...');

//        factory(App\Models\PrefModel::class, \App\Helpers\SeedingHelper::NO_OF_PREF)->create();
//        $this->command->info('Creating sample Pref...');

        // factory(App\Models\ExternalLinksModel::class, \App\Helpers\SeedingHelper::NO_OF_LINKS)->create();
        // $this->command->info('Creating sample external links...');

/*        factory(App\Models\SpecialistModel::class, \App\Helpers\SeedingHelper::NO_OF_SPECIALIST)->create();
        $this->command->info('Creating sample Specialist...');


        factory(App\Models\CountryModel::class, \App\Helpers\SeedingHelper::NO_OF_COUNTRY)->create();
        $this->command->info('Creating sample country...');

        factory(App\Models\CityModel::class, \App\Helpers\SeedingHelper::NO_OF_CITY)->create();
        $this->command->info('Creating sample City...');
        
        factory(App\Models\TownModel::class, \App\Helpers\SeedingHelper::NO_OF_TOWN)->create();
        $this->command->info('Creating sample Town...');
        
        factory(App\Models\ClientModel::class, \App\Helpers\SeedingHelper::NO_OF_CLIENTS)->create();
        $this->command->info('Creating sample Clients...');

        factory(App\Models\LicenceModel::class, \App\Helpers\SeedingHelper::NO_OF_LICENCES)->create();
        $this->command->info('Creating sample Licences...');

        factory(App\Models\LicenceUpdateModel::class, \App\Helpers\SeedingHelper::NO_OF_LICENCE_UPDATES)->create();
        $this->command->info('Creating sample Licence Updates...');

        factory(App\Models\AndroidLicenceModel::class, \App\Helpers\SeedingHelper::NO_OF_ANDROID_LICENCES)->create();
        $this->command->info('Creating sample Android Licences...');

        factory(App\Models\AndroidLicenceUpdateModel::class, \App\Helpers\SeedingHelper::NO_OF_ANDROID_LICENCE_UPDATES)->create();
        $this->command->info('Creating sample Android Licence Updates ...');

        factory(App\Models\BackUpLicenceModel::class, \App\Helpers\SeedingHelper::NO_OF_BACKUP_LICENCES)->create();
        $this->command->info('Creating sample BackUp Licences ...');

        factory(\App\Models\BackUpFileModel::class, \App\Helpers\SeedingHelper::NO_OF_BACKUP_FILES)->create();
                $this->command->info('Creating sample BackUp Files...');


        factory(App\Models\DrugModel::class, \App\Helpers\SeedingHelper::NO_OF_DRUGS)->create();
        $this->command->info('Creating sample Drugs...');


        factory(App\Models\PatientModel::class, \App\Helpers\SeedingHelper::NO_OF_PATIENTS)->create();
        $this->command->info('Creating sample Patients...');

        factory(App\Models\TestModel::class, \App\Helpers\SeedingHelper::NO_OF_TEST)->create();
                $this->command->info('Creating sample Tests...');
                
        factory(App\Models\RayModel::class, \App\Helpers\SeedingHelper::NO_OF_RAY)->create();
                $this->command->info('Creating sample Ray...');

        factory(App\Models\PatientClientModel::class, \App\Helpers\SeedingHelper::NO_OF_PATIENTS_AND_DOCTORS)->create();
        $this->command->info('Creating sample Patients and doctors...');


        factory(App\Models\ClientUserModel::class, \App\Helpers\SeedingHelper::NO_OF_CLIENTS)->create();
        $this->command->info('Creating sample Client User...');

        factory(App\Models\ExpressVersionUpdatesModel::class, \App\Helpers\SeedingHelper::NO_OF_EXPRESS_VERSION_UPDATES)->create();
        $this->command->info('Creating Express Version Updates...');

        factory(App\Models\ExpressVersionModel::class, \App\Helpers\SeedingHelper::NO_OF_EXPRESS_VERSION)->create();
        $this->command->info('Creating Express Version ...');


        factory(App\Models\RadiologyLabModel::class, \App\Helpers\SeedingHelper::NO_OF_RADIOLOGY_LAB)->create();
        $this->command->info('Creating sample Radiology Lab...');

        factory(App\Models\LabModel::class, \App\Helpers\SeedingHelper::NO_OF_LAB)->create();
        $this->command->info('Creating sample Labs...');

        factory(App\Models\ScanModel::class, \App\Helpers\SeedingHelper::NO_OF_SCAN)->create();
        $this->command->info('Creating sample Scan...');*/
    }
}
