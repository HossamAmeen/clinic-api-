<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientModel;
use App\Models\LabModel;
use App\Models\UserModel;

class DrugModel extends Model
{
    protected $table = 'drug_tb';

    protected $fillable = [
        'title','is_verified','user_id','active'
    ];

    public static function getAllDrugs()
    {
        $query = "select r.id, r.title, r.is_verified,c.clinic_name,c.doctor_full_name 
        from drug_tb as r, client_tb as c ";
        $query .= "where c.id = r.client_id and r.active = 1 ";
        		//and l.end_on > c.created_at
        $clients = DB::select($query);
        return $clients;
    }

    public static function api_update_drug($client_id)
    {
        $drugs = Input::get('drugs');

        foreach ($drugs as $key => $value)
        {
            $existDrug = DrugModel::where('title' , $value)->first();
            if(!$existDrug)
            {
                $drug = new DrugModel;
                $drug->title = $value;
                $drug->client_id = $client_id;
                $drug->save();
            }
        }
    }

     public static function get_drugs_titles_after_datetime($data_last_updated)
    {
            $query = "select distinct title  ";
            $query .= "from drug_tb ";
            $query .= "where created_at > '$data_last_updated' and active = 1 ";
            $results = DB::select($query);
            
            $counter = 0;
             $drugs;
            foreach ($results as $key=>  $value) {
              $drugs[$counter++]['title'][$key] = $value->title;
              }
             return $drugs;
        
    }//end function 

    public static function saveDrug()
    {
        $drug = new DrugModel;
        $drug->title = Input::get('title');
        $drug->user_id = Auth::user()->id; 
        $drug->client_id = Auth::user()->id; 
        $drug->save();
    }

    public static function update_drug($drugId)
    {
        $drug = DrugModel::find($drugId);
        $drug->title = Input::get('title');
        
        $drug->save();
    }

    public function deactivate(){
        $this->active = 0;
        $this->user_id = Auth::id();
        $this->save();
    }

    public static function store_drug()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $check = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);

        if($check)
        {
            $drugs = Input::get('drugs');
            $drug = new DrugModel;
            $drug->title = $drugs['title'];
            $drug->client_pk_value = Input::get('licence_serial_no');
            $drug->town_id = $drugs['town_id'];
            $drug->client_id = $drugs['client_id'];
            $drug->save();
            $return = [];
            $return['success'] = true;
            $return['data']=[];
            
            echo json_encode($return);
            return;
        }
        $return = [];
        $return['success'] = false;
        $return['data']=[];
        echo json_encode($return);
    }

    public static function download_drug()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $last_date = Input::get('last_date');

        $isExists = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);

        if($isExists)
        {
            $drugs = DrugModel::where('active', '=', 1)->where('created_at', '>', $last_date)->get();
            $last_drug = DrugModel::orderBy('created_at', 'DESC')->first();    

            if(!empty($drugs))
            {
                $return = [];
                $return['success'] = true;
                $return['data']=$drugs;
                $return['last_downloaded_drugs'] = $last_drug->created_at->format('Y-m-d h:i:s');
            }
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
