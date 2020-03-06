<?php

namespace App\Models;

use App\Helpers\APIHelper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ClientModel;
use Illuminate\Support\Facades\Log;


class RadiologyLabModel extends Model
{
    protected $table = 'radiology_lab_tb';

    protected $fillable = [
        'title','address','tel','client_pk_value','town_id','client_id','user_id'
    ];

    public static function store_radiology()
    {

        Log::info('trying to add lab');
        Log::info($_POST);


        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');

        $isExists = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);
        Log::info("is exists client " . $isExists);

        if(!$isExists){
            APIHelper::return_false_api_process();
            return;
        }

            $radioloies = Input::get('radioloies');
            $radioloy = new RadiologyLabModel;
            $radioloy->title = $radioloies['title'];
            $radioloy->client_pk_value = Input::get('client_pk_value');
            $radioloy->town_id = $radioloies['town_id'];
            $radioloy->address = $radioloies['address'];
            $radioloy->tel = $radioloies['tel'];
            $radioloy->client_id = $licence_serial_no;
            $radioloy->save();

            $return = [];
            $return['success'] = true;
            $return['data']=[];
            
            echo json_encode($return);
            return;


    }

    public static function download_radiology()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');

        $lastDateTime = APIHelper::read_datetime('last_date');
        $town_id = Input::get('town_id');
        if(!empty($town_id)){
            $town_id = intval(Input::get('town_id'));
        }

        $isExists = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);

        if(!$isExists){
            APIHelper::return_false_api_process();
            return;
        }

        if($town_id){
            $labs = RadiologyLabModel::where('town_id', '=', $town_id)
                ->where('created_at', '>', $lastDateTime)
                ->where('active','=','1')
                ->where('is_accept_updates','=','1')
                ->where('client_id','!=',$licence_serial_no)
                ->get();
        }else{
            $labs = RadiologyLabModel::where('active','=','1')
                ->where('created_at', '>', $lastDateTime)
                ->where('is_accept_updates','=','1')
                ->where('client_id','!=',$licence_serial_no)
                ->get();
        }

        Log::info($labs);

        if(!empty($labs))
        {
            $last_radiology_lab_created_at = LabModel::orderBy('created_at', 'DESC')->first();
        }
        else
        {
            $last_radiology_lab_created_at = date('Y-m-d H:i:s');
        }

        if(!empty($labs))
        {
            $return = [];
            $return['success'] = true;
            $return['data']=$labs;
            $return['date_of_last_radiology'] = $last_radiology_lab_created_at;
        }

        echo json_encode($return);


    }//end download radiology model
}
