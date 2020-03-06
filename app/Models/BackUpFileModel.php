<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;
use App\Helpers\FileHelper;
use App\Models\ClientModel;
use Illuminate\Support\Facades\URL;

class BackUpFileModel extends Model
{
    protected $table = "back_up_files_tb";

    protected $fillable = [
        'no_of_using','url','user_id','active','backup_licence_id'
    ];

    public static function get_last_backup_file_url()
    {
        $licence_serial_no = Input::get('licence_serial_no');

        $query = 'select bk_f.url as url, bk_f.id as id ';
        $query .= 'from licence_tb as l, client_tb as c ,
                users_tb as u ,
                back_up_files_tb as bk_f ,
                client_user_tb as cu ,
                backup_licence_tb as bk_l ';
        $query .= 'WHERE bk_f.backup_licence_id = bk_l.id ';
        $query .= "and bk_l.licence_id = $licence_serial_no ";
        $query .= 'ORDER by bk_f.id DESC  LIMIT 1 ';

        $results = DB::select($query);

        if(!empty($results[0])){
            $url = URL::to($results[0]->url);
            //increase no of using by 1
            $mBackupFile = BackUpFileModel::find($results[0]->id);
            $mBackupFile->no_of_using = $mBackupFile->no_of_using + 1 ;
            $mBackupFile->save();
        }else{
            $url= null;
        }

        return $url;
    }//end get last backup file url


    public static function get_backup_licence_id_by_licence_id ($licenceId)
    {
        $query = 'select bk_l.id as id ';
        $query .= 'from licence_tb as l, backup_licence_tb as bk_l ';
        $query .= "where l.id = '$licenceId' ";
        $query .= "and bk_l.licence_id = l.id ";
        $results = DB::select($query);

        if(!empty($results[0]))
            return $results[0]->id;
        else
            return false;
    }
    
    public static function upload_backup_file($licence_id)
    {

        $backup_licence_id = BackUpFileModel::get_backup_licence_id_by_licence_id($licence_id);

        $file = FileHelper::upload_file('file','resources/backup_files');
        $media = array(
            'url' =>$file,
            'user_id'=>1,
            'active' => 1,
            'backup_licence_id' => $backup_licence_id
        );
        //save file
        BackUpFileModel::create($media);
        

    }

    
}
