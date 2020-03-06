<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
use App\Helpers\FileHelper;
use App\Models\ClientModel;
use Illuminate\Support\Facades\URL;

class ClientFileModel extends Model
{
    protected $table = "client_file_tb";

    protected $fillable = [
        'title','url','user_id','active','size','extension','client_file_id','client_id'
    ];

    public static function upload_file(){
        $client_id = Input::get('licence_serial_no');
        $client_file_id = Input::get('client_file_id');
        $data = FileHelper::upload_file_and_return_details($client_id);

        $mClientFile = new ClientFileModel();
        $mClientFile->client_id = $client_id;
        $mClientFile->client_file_id = $client_file_id;
        $mClientFile->size = $data['size'];
        $mClientFile->title = $data['title'];
        $mClientFile->extension = $data['extension'];
        $mClientFile->url = $data['url'];
        $mClientFile->save();

    }//end run upload file

    public static function get_client_total_files_size($client_id){
        $query = "select sum(size) as total_size ";
        $query .= "from client_file_tb ";
        $query .= "where client_id = {$client_id} ";
        $query .= "and active = 1 ";
        $results = DB::select($query);
        return $results[0]->total_size;

    }//end get_client_total_files_size

    public static function download_file(){
        $client_id = Input::get('licence_serial_no');
        $client_file_id = Input::get('client_file_id');

        $query = "select url ";
        $query .= "from client_file_tb ";
        $query .= "where client_id = {$client_id} ";
        $query .= "and client_file_id = {$client_file_id} ";
        $query .= "and active = 1  ";
        $query .= "Limit 1 ";
        $results = DB::select($query);
        if(!empty($results[0]))
            return URL::to($results[0]->url);
        else
            return false;

    }//end run upload file

}//end client file model
