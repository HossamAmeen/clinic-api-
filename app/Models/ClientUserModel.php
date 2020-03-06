<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientUserModel extends Model
{
    protected  $table = "client_user_tb";

    protected $fillable = [
        'user_id', 'client_id','active'
    ];

    public static function create_client_user($user_id, $client_id){
        $mClientUser = new  ClientUserModel();
        $mClientUser->user_id = $user_id;
        $mClientUser->client_id = $client_id;
        $mClientUser->save();
    }
}
