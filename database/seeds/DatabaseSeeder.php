<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the applications's database.
     *
     * @return void
     */
    public function run()
    {

        App\Models\UserModel::create(['first_name' => 'abd',
            'last_name' => 'abdelrahman',
            'user_name' => 'elzedy',
            'password' => bcrypt('admin'),
            'role' => '1',
            'active' => '1',
            'email' => rand() . 'info@u-clinics.com',
            'img' => \App\Models\UserModel::MALE_LOGO,
        ]);

        App\Models\PrefModel::create([
            'name' => 'asd',
            'user_id' => 1,
        ]);
        App\Models\CountryModel::create([
            'ar_title' => 'مصر',
            'user_id' => 1,
        ]);
        App\Models\CityModel::create([
            'ar_title' => 'اسيوط',
            'country_id' => 1,
        ]);
        App\Models\TownModel::create([
            'ar_title' => 'اسيوط',
            'city_id' => 1,
        ]);

        App\Models\UserModel::create(
            ['first_name' => 'clinic',
                'last_name' => 'test',
                'user_name' => 'testclinic',
                'password' => bcrypt('admin'),
                'role' => '0',
                'active' => '1',
                'email' => 'testclinic@u-clinics.com',
                'img' => \App\Models\UserModel::MALE_LOGO,
            ]);

        App\Models\ClientModel::create([

            'client_email' => 'clinic_email',
            'doctor_tel' => 'asd',

            'doctor_full_name' => 'asd',
            '__TOKEN' => 'asd',
            'client_user_id' => 2,
            'user_id' => 1,
        ]);
        App\Models\ClientUserModel::create(
            [
                'user_id' => '2',
                'client_id' => '1',
            ]);
        App\Models\Clinic::create(

            [
                'clinic_name' => "clinic test",
                'clinic_tel' => "01010079798",
                'mac_address' => "123456789",
                'client_id' => '1',
                'user_id' => '1',

            ]);

        App\Models\LicenceModel::create([
            'start_on' => '2020-01-01',
            'end_on' => '2020-12-01',
            'clinic_id' => 1,
            'user_id' => 1,
        ]);
        App\Models\PatientModel::create([
            'full_name' => 'asd',
            'client_id' => 1,
            'user_id' => 1,
        ]);
        $this->daysSeeder();
        factory(App\Models\UserModel::class, \App\Helpers\SeedingHelper::NO_OF_USERS)->create();
        $this->command->info('Creating sample users...');

        factory(App\Models\PrefModel::class, \App\Helpers\SeedingHelper::NO_OF_PREF)->create();
        $this->command->info('Creating sample Pref...');
        factory(App\Models\CountryModel::class, \App\Helpers\SeedingHelper::NO_OF_COUNTRY)->create();
        $this->command->info('Creating sample country...');

        factory(App\Models\CityModel::class, \App\Helpers\SeedingHelper::NO_OF_CITY)->create();
        $this->command->info('Creating sample City...');
        factory(App\Models\TownModel::class, \App\Helpers\SeedingHelper::NO_OF_TOWN)->create();
        $this->command->info('Creating sample Town...');
        factory(App\Models\ExternalLinksModel::class, \App\Helpers\SeedingHelper::NO_OF_LINKS)->create();
        $this->command->info('Creating sample external links...');
        factory(App\Models\SpecialistModel::class, \App\Helpers\SeedingHelper::NO_OF_SPECIALIST)->create();
        $this->command->info('Creating sample Specialist...');
        factory(App\Models\ClientModel::class, \App\Helpers\SeedingHelper::NO_OF_CLIENTS)->create();
        $this->command->info('Creating sample Clients...');
        factory(App\Models\Clinic::class, \App\Helpers\SeedingHelper::NO_OF_CLIENTS)->create();
        $this->command->info('Creating sample Client User...');

        factory(App\Models\ClientModel::class, \App\Helpers\SeedingHelper::NO_OF_CLIENTS)->create();
        $this->command->info('Creating sample Clients...');
        factory(App\Models\LicenceModel::class, \App\Helpers\SeedingHelper::NO_OF_LICENCES)->create();
        $this->command->info('Creating sample Licences...');

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
        
        factory(App\Models\VisitType::class, \App\Helpers\SeedingHelper::NO_OF_PATIENTS)->create();
        $this->command->info('Creating sample visits...');

        factory(App\Models\Appointment::class, \App\Helpers\SeedingHelper::NO_OF_APPOINTMENT)->create();
        $this->command->info('Creating sample Appointments...');

        factory(App\Models\PatientVisitModel::class, \App\Helpers\SeedingHelper::NO_OF_VISIT)->create();
        $this->command->info('Creating sample PatientVisits...');

        factory(App\Models\TestModel::class, \App\Helpers\SeedingHelper::NO_OF_TEST)->create();
        $this->command->info('Creating sample Tests...');

        // factory(App\Models\RayModel::class, \App\Helpers\SeedingHelper::NO_OF_RAY)->create();
        // $this->command->info('Creating sample Ray...');

        factory(App\Models\PatientClientModel::class, \App\Helpers\SeedingHelper::NO_OF_PATIENTS_AND_DOCTORS)->create();
        $this->command->info('Creating sample Patients and doctors...');

        factory(App\Models\ExpressVersionUpdatesModel::class, \App\Helpers\SeedingHelper::NO_OF_EXPRESS_VERSION_UPDATES)->create();
        $this->command->info('Creating Express Version Updates...');

        factory(App\Models\ExpressVersionModel::class, \App\Helpers\SeedingHelper::NO_OF_EXPRESS_VERSION)->create();
        $this->command->info('Creating Express Version ...');

        factory(App\Models\RadiologyLabModel::class, \App\Helpers\SeedingHelper::NO_OF_RADIOLOGY_LAB)->create();
        $this->command->info('Creating sample Radiology Lab...');

        factory(App\Models\LabModel::class, \App\Helpers\SeedingHelper::NO_OF_LAB)->create();
        $this->command->info('Creating sample Labs...');

        factory(App\Models\ScanModel::class, \App\Helpers\SeedingHelper::NO_OF_SCAN)->create();
        $this->command->info('Creating sample Scan...');
    }
    public function daysSeeder()
    {
        $day = new \App\Models\Day();
        $day->ar_title = "السبت";
        $day->en_title = "Saturday";
        $day->save();

        $day = new \App\Models\Day();
        $day->ar_title = "الأحَد";
        $day->en_title = "Sunday";
        $day->save();

        $day = new \App\Models\Day();
        $day->ar_title = "الإثنين";
        $day->en_title = "Monday";
        $day->save();

        $day = new \App\Models\Day();
        $day->ar_title = "الثلاثاء";
        $day->en_title = "Tuesday";
        $day->save();

        $day = new \App\Models\Day();
        $day->ar_title = "الأربعاء";
        $day->en_title = "Wednesday";
        $day->save();

        $day = new \App\Models\Day();
        $day->ar_title = "الخميس";
        $day->en_title = "Thursday";
        $day->save();

        $day = new \App\Models\Day();
        $day->ar_title = "الجمعة";
        $day->en_title = "Friday";
        $day->save();
    }
}
