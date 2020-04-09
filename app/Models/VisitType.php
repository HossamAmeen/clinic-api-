<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitType extends Model
{
    protected $table = "visit_type_tb";
    protected $fillable = ['title' ,'expectation_period_in_minutes' ,
    'is_favourite', 'fees' ,'clinic_id', 'user_id', 'client_visit_type_id' ,'active'];
}
