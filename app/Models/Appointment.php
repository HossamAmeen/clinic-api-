<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected  $table = "appointments_tb";

    protected $fillable = [
        'date' , 'from_time','to_time',
    'is_online_reservation','visit_type_id'
    ,'patient_id' ,'clinic_id', 'user_id' ,'active'];

    public function patient()
    {
        // return $this->belongsTo(PatientModel::class , 'patient_id');
        return $this->belongsTo(PatientModel::class , 'patient_id');
    }

    public function vistType()
    {
        // return $this->belongsTo(PatientModel::class , 'patient_id');
        return $this->belongsTo(VisitType::class , 'visit_type_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class , 'clinic_id');
    }
}
