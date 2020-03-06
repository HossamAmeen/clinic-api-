<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Log;


class LicenceModel extends Model
{
    protected $table = 'licence_tb';

    protected $fillable = [
        'start_on','end_on','client_id','active','user_id'
    ];

    public static function new_licence($clientId)
    {
        $currentDate = date('Y-m-d');
        $nextYear =  date('Y-m-d', strtotime("+1 months $currentDate"));

        $mLicence = new LicenceModel;
        $mLicence->start_on = $currentDate;
        $mLicence->end_on = $nextYear;
        $mLicence->client_id = $clientId;
        $mLicence->user_id = null;

        $mLicence->save();
        LicenceUpdateModel::set_update_licence_record($mLicence);


        return $mLicence;
    }

    public static function update_licence()
    {

        $MacAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');

        $query = 'select l.end_on as licence_end_on ';
        $query .= 'from licence_tb as l, client_tb as c , users_tb as u ';
        $query .= "where c.mac_address = '$MacAddress' ";
        $query .= "and u.user_name = '$user_name' ";
        $query .= "and l.client_id = c.id ";
 		$query .= "and l.id = '$licence_serial_no' ";
 		$query .= "limit 1 ";

//        Log::info($query);

        //echo $query;
        $results = DB::select($query);


        if(!empty($results))
        {
            $return = [];
            $return['success'] = true;
            $return['data']['licience_end_on']=$results[0]->licence_end_on;

        }
        else
        	{$return = [];
        	        $return['success'] = false;
        	}
        echo json_encode($return);
    }
}
