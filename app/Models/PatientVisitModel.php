<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVisitModel extends Model
{
    protected  $table = "patient_visit_tb";

    protected $fillable = [
        'user_id', 'client_id','active','initial_diagnose',
        // 'prescription_image',
        'notes','consultation_date',
        'visit_datetime','client_id','patient_id'
    ];

        public function visitType()
        {
            return $this->belongsTo(VisitType::class);
        }
        public function prescriptionImages()
        {
            return $this->hasMany(PrescriptionImage::class , 'visit_id');
        }
        public function patient()
        {
            return $this->belongsTo(PatientModel::class);
        }
}//end patient visit
