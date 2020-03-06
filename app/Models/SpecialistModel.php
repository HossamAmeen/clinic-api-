<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialistModel extends Model
{
    protected $table = 'specialist_tb';

    protected $fillable = [
        'ar_title','en_title','user_id'
    ];

    public static function download_specialists()
    {

        $specialists = SpecialistModel::where('active', '=', 1)->get(['id','ar_title']);

        if(!empty($specialists)) {
            $return = [];
            $return['success'] = true;
            $return['data'] = $specialists;
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
