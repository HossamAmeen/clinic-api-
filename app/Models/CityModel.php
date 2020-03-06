<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
	
class CityModel extends Model
{
    protected $table = 'city_tb';

    protected $fillable = [
        'ar_title','en_title','country_id','is_default','user_id'
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\CountryModel','country_id');
    }

    public function towns()
    {
        return $this->hasMany('App\Models\TownModel','town_id');
    }

    public static function download_city()
    {
        $cities = CityModel::where('active', '=', 1)->get(['id','ar_title','country_id']);

            if(!empty($cities))
            {
                $return = [];
                $return['success'] = true;
                $return['data']=$cities;
             }

        else
        {
            $return = [];
            $return['success'] = true;
            $return['data']=[];
        }

        echo json_encode($return);
    }
}
