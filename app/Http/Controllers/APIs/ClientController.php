<?php

namespace App\Http\Controllers\APIs;
use App\Http\Controllers\APIResponseTrait;
use App\Models\ClientModel;
use App\Models\Order;
use App\Models\UserModel;
use Auth;
use Mail;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    use APIResponseTrait;
    public function login()
    {
        $credentials = request(['user_name', 'password']);

        if(Auth::attempt($credentials, false, false)){
            $data['id'] = Auth::user()->id;
            $client = UserModel::where("user_name", request('user_name'))->first();
            // $success['token'] =  $client->createToken('token')->accessToken;
            
            return $this->APIResponse($data, null, 200);
        }
        $error = "Unauthorized";
        return $this->APIResponse(null, $error, 400);
       
    }
    public function getAccount()
    {
        // $client = UserModel::findOrFail(request('id')); Input::get('id')
        // $client = ClientModel::where('client_user_id' , Auth::guard('api')->user()->id)->first();
        $client = ClientModel::where('client_user_id' , request('id') )->first();
        return $this->APIResponse($client, null, 201);
    }

    public function updateAccount(Request $request)
    {
        $user = UserModel::find(request('id'));
        $client = ClientModel::where('client_user_id' , $user->id)->first();
        if(isset($client))
        {
            // return $client;
            $client->clinic_email = $request->clinic_email ;
            $client->clinic_name = $request->clinic_name;
            $client->doctor_full_name = $request->doctor_full_name;
            $client->doctor_tel = $request->doctor_tel;
            $client->specialist_id   = $request->specialist_id;
            $client->country_id   = $request->country_id;
            $client->city_id   = $request->city_id;
            $client->town_id   = $request->town_id; 
            $client->save();
            return $this->APIResponse(null, null, 201);
        }
        $error = "not found";
        return $this->APIResponse(null, $error, 404);

    }
    
    public function updatePassword(Request $request)
    {

        $user = UserModel::find(request('id'));
       
        if(isset($user))
        {
            // return $client;
            $user->password =  bcrypt($request->password) ; 
        $user->save();
            return $this->APIResponse(null, null, 201);
        }
        $error = "not found";
        return $this->APIResponse(null, $error, 404);

    }

    public function getLastLicence()
    {
        // return request('id') ;
        $client = ClientModel::where('client_user_id' ,request('id'))->first();
        return $this->APIResponse(\App\Models\LicenceModel::where('client_id',$client->id)->first(), null, 201);
    }
    public function getPatients()
    {
        
        $client = ClientModel::where('client_user_id' ,request('id'))->first();
        $patients = \App\Models\PatientModel::where('client_id',$client->id)->get();
        $data = array();
        foreach($patients as $patient){
            $datas['id'] =  $patient->id;
           $datas['patient_name'] =  $patient->full_name;
           $visit =  \App\Models\PatientVisitModel::where('patient_id' , $patient->id)->orderBy('id', 'DESC')->first();
           if(isset($visit))
           {
            $datas['initial_diagnose'] = $visit->initial_diagnose;
            $datas['date'] = $visit->created_at->format('Y-m-d');
            $datas['address'] = $patient->address;
           }
           else
           {
            $datas['initial_diagnose'] = " ";
            $datas['date'] = " ";
           }
         
           $data[] = $datas;   
        }
        // return $patients;
        // return "tess";
        return $this->APIResponse($data, null, 201);
        
    }

    public function getPatient($id)
    {
        // return $this->APIResponse(\App\Models\PatientModel::find($id), null, 201);
        return $this->APIResponse(\App\Models\PatientModel::withCount('visits')->find($id), null, 201);
    }
    public function getPatientVisits($id)
    {
        return $this->APIResponse(\App\Models\PatientVisitModel::where('patient_id' , $id)->get(), null, 201);
    }
    public function getAppointments($clinic_id = null)
    {
        if($clinic_id == null)
            // return $this->APIResponse(\App\Models\Appointment::where('user_id' , request('id'))->get(), null, 201)->with('patient');
            return $this->APIResponse(\App\Models\Appointment::with(['vistType','clinic','patient'])
            ->where('user_id' , request('id'))
            ->where('date' , date('Y-m-d'))
            ->orderBy('from_time')
            ->get(),
            
            null, 201);
        else
        {
            return $this->APIResponse(\App\Models\Appointment::with(['vistType','clinic','patient'])
            ->where('user_id' , request('id'))
            ->where('date' , date('Y-m-d'))
            ->where('clinic_id' , $clinic_id)
            ->orderBy('from_time')
            ->get(), 
            null, 201);
        }
    }
    public function setAppointment(Request $request)
    {
       $request['user_id']  = request('id');
        \App\Models\Appointment::create($request->all());
        return $this->APIResponse(null, null, 201);
    }
    public function delayAppointment(Request $request)
    {
    //    $appointments =  \App\Models\Appointment::where('user_id' , request('id'))
    //         ->where('date' , date('Y-m-d'))
    //         ->where('from' ,'>=', request('start_time') )
    //         ->increment('from', "30 minutes");
    $time =  request('delay') ; 
    // $query = "update appointments_tb
    // set from_time = ADDTIME(from_time,'12:$time:00')
    // where date = CURDATE() 
    // and from_time >= " .  request('start_time') . "and user_id = " . request('id');
    $query = "update appointments_tb";
    $query .=" set from_time = ADDTIME(from_time,'00:$time:00')";
    $query .=" where date = CURDATE() and from_time >= '" . request('start_time') ."' and user_id = " . request('id');
    $users = DB::select($query);
    // return $users;
            // ->update(['from' => 3 , 'to' => 4]);
        return $this->APIResponse(null, null, 201);
    }
    public function getPatientVisit($id)
    {
        return $this->APIResponse(\App\Models\PatientVisitModel::find($id), null, 201);
        
    }
    public function sendToken(Request $request)
    {
        $user = UserModel::where("email",$request->email)->first();
        if(isset($user))
        {
            $user->remember_token =   $fourdigitrandom = rand(1000,9999); 
            $user->save();
            $data['remember_token'] = $user->remember_token ; 
            $data['email'] = $user->email ; 
            Mail::send('send_token',$data,function($message) use ($data){
                $message->from("contact@u-clinics.com");
                $message->to( $data['email']);
                $message->subject( 'reset password' );
            });
            return $this->APIResponse(null, null, 201);
        }
        return $this->APIResponse(null, "not found", 404);
      
    }
    public function resetPasswotd(Request $request)
    {
        $user = UserModel::where("remember_token",$request->token)->first();
        // return $user; 
        if(isset($user))
        {
            $user->password =  bcrypt($request->password) ; 
            $user->save();
            return $this->APIResponse(null, null, 201);
        }
        return $this->APIResponse(null, "not found", 404);
    }
}
