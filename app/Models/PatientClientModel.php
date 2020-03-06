<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PatientClientModel extends Model
{
    protected $table= 'patient_client_tb';
    // use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'patient_id','client_id','user_id','active'];
    public function patient()
    {
        return $this->belongsTo(PatientModel::class ,'patient_id' );
    }
    
}
