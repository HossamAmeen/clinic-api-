<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class CountryModel extends Model
{
    protected $table = 'country_tb';

    protected $fillable = [
        'ar_title','en_title','en_abbr','is_default','user_id'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\CityModel','city_id');
    }

    public static function download_country()
    {

            $countries = CountryModel::where('active', '=', 1)->get(['id','ar_title']);

            if(!empty($countries)) {
                $return = [];
                $return['success'] = true;
                $return['data'] = $countries;
            }

        else
        {
            $return = [];
            $return['success'] = false;
            $return['data']=[];
        }

        echo json_encode($return);
    }
}
