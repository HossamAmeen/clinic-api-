<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class PrefModel extends Model
{
    protected $table= 'prefs_tb';
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];


    public static function update_prefs(){
        $mPrefs           = PrefModel::find(1);

        $mPrefs->name    = Input::get('name');
        $mPrefs->description    = Input::get('description');
        $mPrefs->address    = Input::get('address');
        $mPrefs->zedy_web_site      = Input::get('zedy_web_site');
        $mPrefs->sales_tel      = Input::get('sales_tel');
        $mPrefs->call_center      = Input::get('call_center');
        $mPrefs->email    = Input::get('email');
        $mPrefs->whatsapp      = Input::get('whatsapp');
        $mPrefs->facebook = Input::get('facebook');
        $mPrefs->android_download_link   = Input::get('android_download_link');


        $mPrefs->user_id  = Auth::id();

        $mPrefs->save();
    }//end update prefs
}

