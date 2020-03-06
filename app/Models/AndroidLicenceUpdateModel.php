<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AndroidLicenceUpdateModel extends Model
{

    protected $table = "android_licence_updates_tb";
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'start_on','end_on','android_licence_id','active'
    ];

    public static function set_update_licence_record($mAndroidLicence){

        $mAndroidUpdate = new AndroidLicenceUpdateModel();
        $mAndroidUpdate->start_on = $mAndroidLicence->start_on;
        $mAndroidUpdate->end_on = $mAndroidLicence->end_on;
        $mAndroidUpdate->android_licence_id = $mAndroidLicence->id;
        $mAndroidUpdate->save();

    }
}
