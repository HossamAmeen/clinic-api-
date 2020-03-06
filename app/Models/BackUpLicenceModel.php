<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackUpLicenceModel extends Model
{

    protected $table = "backup_licence_tb";
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'start_on','end_on','licence_id','active','user_id'
    ];


    public static function init_backup_licence($mLicence){

        $mBackUpLicence = new BackUpLicenceModel();
        $mBackUpLicence->start_on = $mLicence->start_on;
        $mBackUpLicence->end_on = $mLicence->end_on;
        $mBackUpLicence->licence_id = $mLicence->id;
        $mBackUpLicence->save();

    }
}
