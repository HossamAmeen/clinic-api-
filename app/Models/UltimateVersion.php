<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UltimateVersion extends Model
{
    use SoftDeletes;
    protected $fillable = ['version','file','stable','user_id'];
}
