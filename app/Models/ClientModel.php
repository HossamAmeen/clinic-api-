<?php

namespace App\Models;

use App\Helpers\EmailHelper;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\DrugModel;
use App\Models\PatientModel;
use App\Models\LabModel;
use App\Models\RayModel;
use App\Models\UserModel;
use App\Models\LicenceModel;
use Illuminate\Support\Facades\Log;
use Newsletter;

class ClientModel extends Model
{
    protected  $table = "client_tb";

    protected $primary_key = 'id';

    protected $fillable = [
        'clinic_name','clinic_email','doctor_tel','mac_address','
		doctor_full_name','user_id','end_on','town_id','country_id','city_id','__TOKEN'
    ];
}//end client model
