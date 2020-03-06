<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVisitModel extends Model
{
    protected  $table = "patient_visit_tb";

    protected $fillable = [
        'user_id', 'client_id','active','initial_diagnose',
        'prescription_image','notes','consultation_date',
        'visit_datetime','client_id','patient_id'
    ];

    public static function create_visit(){

        }
}//end patient visit
