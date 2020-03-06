<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientModel;
use App\Models\UserModel;

class TestModel extends Model
{
	protected $table = 'lab_tb';

    protected $fillable = [
        'title','active','user_id','is_verified','client_id'
    ];

    public static function getAllTests()
    {
        $query = "select r.id, r.title, r.is_verified,c.clinic_name,c.doctor_full_name 
        from test_tb as r, client_tb as c ";
        $query .= "where c.id = r.client_id and r.active = 1 ";
        		//and l.end_on > c.created_at
        $clients = DB::select($query);
        return $clients;

    }

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

    public function deactivate(){
        $this->active = 0;
        $this->user_id = Auth::id();
        $this->save();
    }
}
