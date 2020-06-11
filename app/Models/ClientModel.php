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
        'doctor_tel','mac_address','gender',
        'doctor_full_name','user_id','end_on','town_id','country_id','__TOKEN'
    ];

    public function town()
    {
        return $this->belongsTo(TownModel::class);
    }
    public function country()
    {
        return $this->belongsTo(TownModel::class , 'country_id');
    }
    
    public function specialist()
    {
        return $this->belongsTo(SpecialistModel::class , 'specialist_id');
    }
}//end client model
