<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected  $table = "clinic_tb";

    protected $fillable = [
        'clinic_name', 'clinic_tel','facebook','no_of_patients',
        'patient_waiting_time_in_minutes','mac_address','in_clinic_now',
        'client_id','user_id','active'
    ];
}
