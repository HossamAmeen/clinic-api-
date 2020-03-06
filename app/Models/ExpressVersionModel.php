<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use Illuminate\Support\Facades\URL;

class ExpressVersionModel extends Model
{
    protected $table= 'express_version_tb';

    protected $fillable = ['version','file','stable'];

    public static function getAllExpressVersion()
    {
        $query = " select e.id, e.file, e.stable , e.version , e.created_at as created_at 
        	from express_version_tb as e ";
        $query .= "where e.active = 1 ";
        $query .= "order by id desc ";
        		//and l.end_on > c.created_at
        $express = DB::select($query);
        return $express;

    }
}
