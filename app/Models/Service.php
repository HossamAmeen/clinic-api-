<?php

namespace App\Models;


use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class Service extends Model
{
    const DEFAULT_MEDIA_COVER = "resources/assets/admin/assets/images/dummy.jpg";
    protected $table = 'shaker_service_tb';

    public  static function get_services_url(){
        return 'admin/services';
    }

    public  static function create_service(){

        $mService = new Service();
        $mService->ar_title = Input::get('ar_title');
        $mService->en_title = Input::get('en_title');
        $mService->ar_description = Input::get('ar_description');
        $mService->en_description = Input::get('en_description');
        $img = FileHelper::storeImage('img','uploads/services',426,270);
        if(!empty($img)){
            $mService->img = $img;
        }else{
            $mService->img = Service::DEFAULT_MEDIA_COVER;
        }
        $mService->user_id = Auth::id();
        $mService->save();

    }//end create service

    public  static function update_service($serviceId){
        $mService =  Service::find(intval($serviceId));
        $mService->ar_title = Input::get('ar_title');
        $mService->en_title = Input::get('en_title');
        $mService->ar_description = Input::get('ar_description');
        $mService->en_description = Input::get('en_description');
        $img = FileHelper::storeImage('img','uploads/services',110,100);
        if(!empty($img)){
            $mService->img = $img;
        }
        $mService->user_id = Auth::id();

        $mService->save();
    }


    public function deactivate(){
        $this->active = 0;
        $this->user_id = Auth::id();
        $this->save();
    }


    public static function get_all_services_ar_title(){
        $query = "select id, ar_title ";
        $query .= "from service_tb ";
        $query .= "where active = 1 ";
        return \DB::select($query);
    }

    public static function get_all_services_en_title(){
        $query = "select id, en_title ";
        $query .= "from service_tb ";
        $query .= "where active = 1 ";
        return \DB::select($query);
    }

    public static function get_all_ar_services(){
        $query = "select id, ar_title, img ";
        $query .= "from service_tb ";
        $query .= "where active = 1 ";
        return \DB::select($query);
    }
    public static function get_all_en_services(){
        $query = "select id, en_title, img ";
        $query .= "from service_tb ";
        $query .= "where active = 1 ";
        return \DB::select($query);
    }

}
