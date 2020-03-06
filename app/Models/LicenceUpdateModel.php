<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LicenceUpdateModel extends Model
{
    protected $table= 'licence_updates_tb';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'from','to','active','licence_id'
    ];


    public static function set_update_licence_record($mLicence){

        $mLicenceUpdate = new LicenceUpdateModel();
        $mLicenceUpdate->from = $mLicence->start_on;
        $mLicenceUpdate->to = $mLicence->end_on;
        $mLicenceUpdate->licence_id = $mLicence->id;
        $mLicenceUpdate->save();

    }

}
