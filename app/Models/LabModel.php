<?php

namespace App\Models;

use App\Helpers\APIHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ClientModel;

use Illuminate\Support\Facades\Log;

class LabModel extends Model
{
	protected $table = 'lab_tb';



    protected $fillable = [
        'title','address','tel','client_pk_value','town_id','client_id','user_id'
    ];


    public static function get_all_labs()
    {
        $query = "select r.id, r.title, r.is_verified,c.clinic_name,c.doctor_full_name
        from test_tb as r, client_tb as c ";
        $query .= "where c.id = r.client_id and r.active = 1 ";
        //and l.end_on > c.created_at
        $clients = DB::select($query);
        return $clients;

    }

    public static function create_lab()
    {
        $drug = new LabModel();
        $drug->title = Input::get('title');
        $drug->user_id = Auth::user()->id;
        $drug->client_id = Auth::user()->id;
        $drug->save();
    }

    /*
        public static function api_update_test($client_id)
        {
            $tests = Input::get('tests');

            foreach ($tests as $key => $value)
            {
                $existTest = TestModel::where('title' , $value)->first();
                if(!$existTest)
                {
                    $testRow = array(
                        'title' =>$value,
                        'client_id' =>$client_id
                    );
                    $testRow = TestModel::create($testRow);
                }
            }
        }

        public static function get_tests_titles_after_datetime($data_last_updated, $clientId)
        {
            $query = "select distinct title  ";
            $query .= "from test_tb ";
            $query .= "where created_at > '$data_last_updated' and client_id != $clientId and active = 1 ";
            $results = DB::select($query);

            $counter = 0;
            $tests;
            foreach ($results as $key=>  $value) {
                $tests[$counter++]['title'][$key] = $value->title;
            }
            return $tests;
        }

        public static function saveTest()
        {
            $drug = new TestModel;
            $drug->title = Input::get('title');
            $drug->user_id = Auth::user()->id;
            $drug->client_id = Auth::user()->id;
            $drug->save();
        }

        public static function update_test($drugId)
        {
            $drug = TestModel::find($drugId);
            $drug->title = Input::get('title');

            $drug->save();
        }
    */
    public function deactivate(){
        $this->active = 0;
        $this->user_id = Auth::id();
        $this->save();
    }

    public static function api_update_lab($client_id)
    {
        $labs = Input::get('labs');

        foreach ($labs as $key => $value)
        {
            $existLab = LabModel::where('title' , $value)->first();
            if(!$existLab)
            {
                $lab = new LabModel;
                $lab->title = $value;
                $lab->client_id = $client_id;
                $lab->save();
            }
        }
    }

    //why??
     public static function get_labs_titles_after_datetime($data_last_updated)
    {
            $query = "select distinct title  ";
            $query .= "from lab_tb ";
            $query .= "where created_at > '$data_last_updated' and active = 1 ";
            $results = DB::select($query);
            
            $counter = 0; 
            $labs;
            foreach ($results as $key=>  $value) {
              $labs[$counter++]['title'][$key] = $value->title;
              }
             return $labs;
        
    }//end function 

    public static function store_lab()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $check = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);

        if($check)
        {
            $labs = Input::get('labs');
            $lab = new LabModel;
            $lab->title = $labs['title'];
            $lab->client_pk_value = $labs['client_pk_value'];
            $lab->town_id = $labs['town_id'];
            $lab->address = $labs['address'];
            $lab->tel = $labs['tel'];
            $lab->client_id = $licence_serial_no;
            $lab->save();
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

    public static function download_lab()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');

        $lastDateTiem = APIHelper::read_datetime('last_date');
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
                $labs = LabModel::where('town_id', '=', $town_id)
                    ->where('created_at', '>', $lastDateTiem)
                    ->where('active','=','1')
                    ->where('is_accept_updates','=','1')
                    ->where('client_id','!=',$licence_serial_no)
                    ->get();
            }else{
                $labs = LabModel::where('active','=','1')
                    ->where('created_at', '>', $lastDateTiem)
                    ->where('is_accept_updates','=','1')
                    ->where('client_id','!=',$licence_serial_no)
                    ->get();
            }

            Log::info($labs);

            if(!empty($labs))
            {
                $last_lab_created_at = LabModel::orderBy('created_at', 'DESC')->first();
            }
            else
            {
                $last_lab_created_at = date('Y-m-d H:i:s');
            }

            if(!empty($labs))
            {
                $return = [];
                $return['success'] = true;
                $return['data']=$labs;
                $return['last_downloaded_labs_datetime'] = $last_lab_created_at;
            }

        echo json_encode($return);
    }//end download labs


}
