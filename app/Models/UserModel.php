<?php

namespace App\Models;

use App\Helpers\EmailHelper;
use App\Helpers\FileHelper;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\ClientModel;
use App\Models\LicenceModel;
use Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Newsletter;


class UserModel extends Authenticatable
{
    use HasApiTokens, Notifiable;
    const MALE_LOGO = 'resources/assets/admin/assets/images/dummy.jpg';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_tb';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','user_name', 'email', 'password','role','img','user_id','active','temp_user_name','temp_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
    public static function update_current_user(){
        $mUser = Auth::user();
        $mUser->user_name = Input::get('user_name');
        $password = Input::get('password');

        if(!empty($password)){
            $mUser->password = bcrypt($password);
        }

        $mUser->email = Input::get('email');
        $img = FileHelper::storeImage('avatar','resources/uploads/profiles');
        if(!empty($img)){
            $mUser->img = $img;
        }

        $mUser->save();

        //send confirm email
        EmailHelper::send_profile_updated_message($mUser->email, $mUser->user_name, $password);
    }//end update current user

    public static function update_user($id){
        $mUser = UserModel::find($id);
        $mUser->user_name = Input::get('user_name');
        $password = Input::get('password');

        if(!empty($password)){
            $mUser->password = bcrypt($password);
        }

        $mUser->email = Input::get('email');
        $mUser->role = intval(Input::get('role'));


        $mUser->save();
    }//end update  user

    public static function getAllManagers(){
        $query = "select * from users_tb ";
        $query .= "where role < 11 ";
        $query .= "and active = 1 ";
        $users = DB::select($query);
        return $users;

    }

    public static function isManger()
    {

        if (!Auth::check()){
            return False;
        }

        $user = Auth::user();

        if($user->role == 1)
            return true;

        //default value
        return FALSE;

    }
    public static function isSuperVisor(){

        if (!Auth::check())
            return False;


        $user = Auth::user();

        if($user->role <= 2 )
            return TRUE;

        //default value
        return FALSE;
    }

    public static function saveManager(){

        $news = array(
            'user_name'=> Input::get('user_name'),
            'password' => bcrypt(Input::get('password')),
            'user_id'=>Auth::id(),
            'role' => intval(Input::get('role')),
            'email'=> Input::get('email'),
            'active'=> 1,
            'img'=> UserModel::MALE_LOGO
        );
        UserModel::create($news);

       /* UserModel::create([
            'user_name'=> Input::get('user_name'),
            'password' => bcrypt(Input::get('password')),
            'user_id'=>Auth::id(),
            'role' => intval(Input::get('role')),
            'email'=> Input::get('email'),
            'active'=> 1,
            'img'=> UserModel::MALE_LOGO

        ]);*/

    }//end save Manager



    public static function checkLogin (){
        if(!Auth::check()){
            return URL::to('/');
        }
    }

    public static function getRoleTitle($roleId){
        switch($roleId){
            case 1: return "مدير عام";
                break;
            case 2: return "مشرف";
                break;
            default:
                return "غير معروف";
        }
    }


    public function deactivate(){
        $this->active = 0;
        $this->save();
    }//end deactivate

    public static function online_login()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $hashPassword = Hash::make($password); 
        $MACAddress = Input::get('MACAddress');
        
        $query = 'select u.id ';
        $query .= 'from users_tb as u , client_tb as c ';
        $query .= "where u.email = '$email' and u.password= '$hashPassword' ";
        $query .= "and c.mac_address = '$MACAddress' ";
        $results = DB::select($query);
        //echo $query;
        if(!empty($results))
        {
            $return = [];
            $return['success'] = true;
            $return['data']=['password' => $password];
        }
        //var_dump($results);
       // echo "empty" ;
        $return = [];
        $return['success'] = false;
        $return['data']=[];
       // var_dump($return);

        echo json_encode($return);
        

    }//end changes

    public static function new_user($role)
    {        
        $mUser = array(
            'user_name' => Input::get('user_name'),
            'first_name' => Input::get('first_name'),
            'last_name' => Input::get('last_name'),
            'email' => Input::get('uemail'),
            'password' => Hash::make(Input::get('password')),
            'role' => $role
        );
        $mUser = UserModel::create($mUser);

//        if(!empty($mUser->email))
//            ClientModel::add_email_to_subscribers($mUser->email, $mUser->first_name . " " . $mUser->last_name);


        return $mUser;
    }




    public function download_data()
    {
        $MACAddress = Input::get('MACAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $data_last_updated = Input::get('data_last_updated');

        $query = 'select r.title , lab.title , d.title ';
        $query .= 'from licence_tb as l, client_tb as c , users_tb as u , back_up_files_tb as bk_l , ray_tb as r , lab_tb as lab , patient_tb as p , drug_tb as d ';
        $query .= "where c.mac_address = '$MACAddress' ";
        $query .= "and u.user_name = '$user_name' ";
        $query .= "and l.id = '$licence_serial_no' ";
        $query .= "limit 1 ";
        //echo $query;
        $results = DB::select($query);
        if(!empty($results))
        {
            $return = [];
            $return['success'] = true;
            $return['data']['file']=$results[0]->url;
        }
        else
            {
                $return = [];
                $return['success'] = false;
                $return['data'] = [];
            }
        echo json_encode($return);
    }

    public static function update_profile()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $updatedRole = Input::get('updatedRole');
        $check = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);

        if($check)
        {
            if($updatedRole !== 100)
                $updatedRole = 1000;
            $updated_user_name = Input::get('updated_user_name');;
            $updated_email = Input::get('updatedRole');

            $query = "select id from client_user_tb where client_id = user_id";

            $results = DB::select($query);
            if($results)
            {
                $user = UserModel::find($results[0]->id);
                $user->user_name = $updated_user_name;
                $user->email = Input::get('email');
                $user->save();
                $return = [];
                $return['success'] = true;
                echo json_encode($return);
            }
        }
        else
            {
                $return = [];
                $return['success'] = false;
                $return['data'] = [];
                echo json_encode($return);
            }

    }

    public static function delete_profile()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $check = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);

        if($check)
        {
            $updated_user_name = Input::get('updated_user_name');;
            $updated_email = Input::get('updatedRole');

            $query = "select id from client_user_tb where client_id = user_id";

            $results = DB::select($query);
            if($results)
            {
                $user = UserModel::find($results[0]->id);
                $user->active = 0;
                $user->user_id = Auth::id();
                $user->save();
                $return = [];
                $return['success'] = true;
                echo json_encode($return);
            }
        }
        else
            {
                $return = [];
                $return['success'] = false;
                $return['data'] = [];
                echo json_encode($return);
            }   
    }

    public static function check_existing_username()
    {
        $user_name = Input::get('user_name');
        if(empty($user_name))
            return false;

        $query = " select u.id as user_id ";
        $query .= "from users_tb as u ";
        $query .= "where u.user_name = '$user_name'  ";
        $query .="LIMIT 1 ";
        $results = DB::select($query);

        if($results)
        {
            $return = [];
            $return['exist'] = true;
            echo json_encode($return);
        }
        else 
        {
            $return = [];
            $return['exist'] = false;
            echo json_encode($return);  
        }
    }

    
    public static function check_existing_user_email()
    {
        $user_email = Input::get('user_email');
        
        if(empty($user_email))
            return false;

        $query = " select u.id as user_id ";
        $query .= "from users_tb as u ";
        $query .= "where u.email = '$user_email'  ";
        $query .="LIMIT 1 ";
        $results = DB::select($query);

        if($results)
        {
            $return = [];
            $return['exist'] = true;
            echo json_encode($return);
        }
        else 
        {
            $return = [];
            $return['exist'] = false;
            echo json_encode($return);  
        }
    }

}
