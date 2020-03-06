<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use SoftDeletes;
    protected $fillable = ['question' , 'answer' , 'patient_id'];

    public function patient()
    {
      return  $this->belongsTo(PatientModel::class , 'patient_id');
    }
}
