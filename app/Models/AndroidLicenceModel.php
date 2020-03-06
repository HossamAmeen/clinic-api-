<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AndroidLicenceModel extends Model
{
    protected  $table = "android_licence_tb";
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'start_on','end_on','user_id','active','licence_id'
    ];


    public static function init_android_licence($mLicence){

        $mAndroidLicence = new AndroidLicenceModel();
        $mAndroidLicence->start_on = $mLicence->start_on;
        $mAndroidLicence->end_on = $mLicence->end_on;
        $mAndroidLicence->licence_id = $mLicence->id;
        $mAndroidLicence->save();

        AndroidLicenceUpdateModel::set_update_licence_record($mAndroidLicence);
    }// end function


}
