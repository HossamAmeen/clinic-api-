<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class ExpressVersionUpdatesModel extends Model
{
   	protected $table= 'express_version_updates_tb';

    protected $fillable = ['title','url','user_id'];

    public static function getAllExpress()
    {
        $query = " select e.id, e.title, e.url , e.version as version, e.md5 as md5  ,e.modified_files as modified_files, e.description as description ,e.created_at as created_at 
        	from express_version_updates_tb as e ";
        $query .= "where e.active = 1 ";
        $query .= "order by id desc ";
        		//and l.end_on > c.created_at
        $express = DB::select($query);
        return $express;

    }

    public static function api_get_last_version_url_and_send_results($type = '')
    {
        $MACAddress = Input::get('MacAddress');
        $no_of_patients = intval(Input::get('no_of_patients'));



        $client = ClientModel::where('mac_address', "$MACAddress")->first();
        $client->no_of_patients = $no_of_patients;
        $client->save();

        $query = 'select e.title as title, e.url as url, e.version as version, e.description as description, e.md5 as md5 ,
        e.new_queries as new_queries ,e.modified_files as modified_files, e.created_at as created_at ';
        $query .= 'from express_version_updates_tb as e ';
        $query .= 'where active = 1 ';
        $query .= " and type = '$type' ";

        $query .= "order by e.created_at desc limit 1 ";
        $results = DB::select($query);

//        Log::info($query);
//        Log::info($results);

        if(!empty($results[0])){
            $url = URL::to($results[0]->url);
            $return = [];
            $return['success'] = true;
            $return['data']['title']= $results[0]->title;
            $return['data']['url']= str_replace("\r\n","",$url);
            $return['data']['version']= $results[0]->version;
            $return['data']['description']= $results[0]->description;
            $return['data']['md5']= $results[0]->md5;
            $return['data']['new_queries']= $results[0]->new_queries;
            $return['data']['modified_files']= $results[0]->modified_files;
            $return['data']['created_at']=$results[0]->created_at;
            //$return['data']['url']=str_replace("\r\n","",$return['data']['url']);

            echo json_encode($return);

        }else{
            $return = [];
            $return['success'] = false;
            $return['data']=[];
            echo json_encode($return);
        }
        

    }//end api get last version url
}
