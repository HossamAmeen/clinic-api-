<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class TownModel extends Model
{
	protected $table = 'town_tb';

    protected $fillable = [
       'id' ,'ar_title','en_title','city_id','is_default','user_id'
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\CountryModel','country_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\CityModel','city_id');
    }

    public static function download_town()
    {

        $towns = TownModel::where('active', '=', 1)->get(['id','ar_title','city_id']);


            if(!empty($towns))
            {
                $return = [];
                $return['success'] = true;
                $return['data'] = $towns ;

            } else{//if empty towns
            $return = [];
            $return['success'] = true;
            $return['data']=[];
        }


        echo json_encode($return);
    }
}
