<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class ExternalLinksModel extends Model
{
    protected $table= 'external_links_tb';
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];


    public static function update_links(){

        $mLinks           = ExternalLinksModel::find(1);
        $mLinks->zedy_url    = Input::get('zedy_url');
        $mLinks->whatsapp_url    = Input::get('whatsapp_url');
        $mLinks->site_url    = Input::get('site_url');
        $mLinks->u_clinics_facebook_url      = Input::get('u_clinics_facebook_url');
        $mLinks->social_media_services_url      = Input::get('social_media_services_url');
        $mLinks->branding_services_url      = Input::get('branding_services_url');
        $mLinks->video_services_url    = Input::get('video_services_url');
        $mLinks->printing_services_url      = Input::get('printing_services_url');
        $mLinks->sites_services_url = Input::get('sites_services_url');
        $mLinks->mobile_services_url = Input::get('mobile_services_url');
        $mLinks->user_id  = Auth::id();
        $mLinks->save();
    }//end update links

    public static function prepare_api(){
        $mLinks = ExternalLinksModel::find(1);
        $data['zedy_url'] = $mLinks->zedy_url;
        $data['whatsapp_url'] = $mLinks->whatsapp_url;
        $data['site_url'] = $mLinks->site_url;
        $data['u_clinics_facebook_url'] = $mLinks->u_clinics_facebook_url;
        $data['social_media_services_url'] = $mLinks->social_media_services_url;
        $data['branding_services_url'] = $mLinks->branding_services_url;
        $data['video_services_url'] = $mLinks->video_services_url;
        $data['printing_services_url'] = $mLinks->printing_services_url;
        $data['sites_services_url'] = $mLinks->sites_services_url;
        $data['mobile_services_url'] = $mLinks->mobile_services_url;
        return $data;

    }//end prepare api
}//end external links model
