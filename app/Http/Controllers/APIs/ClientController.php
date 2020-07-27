<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\APIResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClientModel;
use App\Models\UserModel;
use App\Models\PatientModel;
use App\Models\PatientClientModel;
use App\Models\Clinic; 
use App\Models\LicenceModel;  
use App\Models\{Measurement , Attachment};
use Auth;
use Image, Carbon\Carbon, File;

use DB;
use Illuminate\Http\Request;
use Mail;

class ClientController extends Controller
{
    use APIResponseTrait;
    public function login()
    {
        $credentials = request(['user_name', 'password']);

        if (Auth::attempt($credentials, false, false)) {
            $data = Auth::user();
            $client = UserModel::where("user_name", request('user_name'))->first();
            // $success['token'] =  $client->createToken('token')->accessToken;
            // return $this->APIResponse($data, null, 200);
            $client = ClientModel::where('client_user_id' , Auth::user()->id)->first();
            if(isset($client)){
                $data['id'] =  $client->id;
                $clinic = Clinic::where('client_id' , $client->id)->first(); 
                if(isset( $clinic ))
                {
                    $licence = LicenceModel::where('clinic_id' , $clinic->id )->first();
                    if(isset( $licence ))
                    $data['licence_date'] = $licence->end_on ; 
                    else
                    return $this->APIResponse(null, "licnence not found", 400);
                }
                else
                return $this->APIResponse(null, "clinic not found", 400);
            }
            else
            return $this->APIResponse(null, "client not found", 400);
           
            
            if($data['img'] == null ){
                $data['img'] = asset("avatar.png") ; 
            }
            return $this->APIResponse($data, null, 200);
        }
        $error = "Unauthorized";
        return $this->APIResponse(null, $error, 400);

    }
    public function getAccount()
    {
        // $client = UserModel::findOrFail(request('id')); Input::get('id')
        // $client = ClientModel::where('client_user_id' , Auth::guard('api')->user()->id)->first();twon
        $client = ClientModel::with(['user','town' , 'country' , 'specialist'])->where('client_user_id', request('id'))->first();
        return $this->APIResponse($client, null, 201);
    }

    public function updateAccount(Request $request)
    {
        $user = UserModel::find(request('id'));
        if (isset($user)) {
            $user->update($request->all());
            $client = ClientModel::where('client_user_id', $user->id)->first();
            if (isset($client)) {
                // return $client;
                // $client->clinic_email = $request->clinic_email;
                // $client->clinic_name = $request->clinic_name;
                // $client->doctor_full_name = $request->doctor_full_name;
                // $client->doctor_tel = $request->doctor_tel;
                // $client->specialist_id = $request->specialist_id;
                // $client->country_id = $request->country_id;
                // // $client->city_id = $request->city_id;
                // $client->town_id = $request->town_id;
                $client->update($request->all());
                $client->save();
                return $this->APIResponse(null, null, 201);
            }
            $error = "client not found";
        }
        else
        $error = "user not found";
        return $this->APIResponse(null, $error, 404);

    }
    public function updateImage(Request $request )
    {
        $client = ClientModel::find(request('id'));
        if(isset($client))
        {
            $user = UserModel::find($client->client_user_id);
            if (isset($user) ) {
                    $image = $request->file('image');
                    $folderName    = "uploads/prescription";
    
                    $size = getimagesize($_FILES['image']['tmp_name']);
    
                    if(intval($_FILES['image']['tmp_name']) > 500000)
                    return $this->APIResponse(null, "image size is bigger" , 400 );
                    // return Redirect::back()->withErrors([ '']);
    
                        $height = 800 ;
                        $width = 2000 ; 
                        $actualWidth = $size[0];
                        $actualHeight = $size[1];
                        $widthRatio = $actualWidth / 800;
                        $heightRatio = $actualHeight /2000;
    
                        if($heightRatio > $widthRatio){
                            //height still as it
                            $width = $actualWidth/$heightRatio;
                        }else{
                            //width still as it
                            $height = $actualHeight / $widthRatio;
                        }
    
                if (!is_dir(base_path()."/".$folderName."/".date("Y-m-d"))) {
                    mkdir(base_path()."/".$folderName."/".date("Y-m-d"), 0777, TRUE);
                }
    
                
                $fileName  = time() . '.' . $image->getClientOriginalExtension();
    
                $path = base_path()."/".$folderName."/".date("Y-m-d") . '/' . $fileName;
    
                //width , height
                Image::make($image->getRealPath())->resize($width, $height)->save($path);
                $user->img= asset($folderName."/".date("Y-m-d") . '/' . $fileName) ;
                $user->save();
           
            }
            else
            {
                $error = "user not found";
                return $this->APIResponse(null, $error, 400);
            }
        }
        else
        {
            $error = "client not found";
            return $this->APIResponse(null, $error, 400);
        }
      
        return $this->APIResponse(null, null, 200);
    }
    public function updatePassword(Request $request)
    {

        $user = UserModel::find(request('id'));

        if (isset($user)) {
            // return $client;
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->APIResponse(null, null, 201);
        }
        $error = "not found";
        return $this->APIResponse(null, $error, 404);

    }

    public function getLastLicence()
    {
        // return request('id') ;
        $client = ClientModel::where('client_user_id', request('id'))->first();
        return $this->APIResponse(\App\Models\LicenceModel::where('client_id', $client->id)->first(), null, 201);
    }

  
    public function getPatients()
    {

        $client = ClientModel::find(request('id'));
        if(isset($client))
        {
            $clinics = Clinic::where('client_id' , $client->id)->pluck('id'); 
            $patients = PatientModel::whereIn('client_id', $clinics)->get();
            $data = array();
            foreach ($patients as $patient) {
                $datas['id'] = $patient->id;
                $datas['patient_name'] = $patient->full_name;
                $datas['address'] = $patient->address;
                $visit = \App\Models\PatientVisitModel::where('patient_id', $patient->id)->orderBy('id', 'DESC')->first();
                if (isset($visit)) {
                    $datas['initial_diagnose'] = $visit->initial_diagnose;
                    $datas['date'] = $visit->visit_datetime;
                   
                } else {
                    $datas['initial_diagnose'] = " ";
                    $datas['date'] = " ";
                   
                }
    
                $data[] = $datas;
            }
            // return $patients;
            // return "tess";
            return $this->APIResponse($data, null, 201);
        }
        return $this->APIResponse(null, "this client not found", 400);

    }

    public function getPatient($id)
    {
        // return $this->APIResponse(\App\Models\PatientModel::find($id), null, 201);
        return $this->APIResponse(\App\Models\PatientModel::withCount('visits')->find($id), null, 201);
    }
    public function getPatientVisits()
    {
       
        return $this->APIResponse(\App\Models\PatientVisitModel::with(['visitType', 'prescriptionImages'])->where('patient_id', request('id'))->get(), null, 201);
    }
    public function getAppointments($clinic_id = null)
    {
        if ($clinic_id == null)
        {
            $client = ClientModel::findOrFail(request('id'));
            // return request('id') ;
            // return $client;
            $clinics = Clinic::where('client_id' , $client->id)->pluck('id'); 
            // return $clinics;
        //    return   ;
            return $this->APIResponse( \App\Models\Appointment::with(['vistType', 'clinic', 'patient'])
            ->whereIn('clinic_id', $clinics)
            // ->where('date', date('Y-m-d'))
            ->orderBy('from_time')
            ->get(),
                    // ->get(['id','from_time']),

                null, 201);
        } else {
            
           
            
            return $this->APIResponse(\App\Models\Appointment::with(['vistType', 'clinic', 'patient'])
                    ->where('user_id', request('id'))
                    ->where('date', date('Y-m-d'))
                    ->where('clinic_id', $clinic_id)
                    ->orderBy('from_time')
                    ->get(),
                null, 201);
        }
    }
    public function setAppointment(Request $request)
    {
        $request['clinic_id'] = request('clinic_id');
        // $clinic = Clinic::find(request('clinic_id'));
        
            // return "Test";
           $patient =  PatientClientModel::where('client_id' , request('clinic_id'))->where('client_pk_value' , request('patient_id'))->first();
           if(isset($patient))
           $request['patient_id'] = $patient->patient_id ;  
           else
           return $this->APIResponse(null, "patient not found", 400);
        
        
       
        // return $request->all();
        \App\Models\Appointment::create($request->all());
        return $this->APIResponse(null, null, 201);
    }
    public function delayAppointment(Request $request)
    {
        //    $appointments =  \App\Models\Appointment::where('user_id' , request('id'))
        //         ->where('date' , date('Y-m-d'))
        //         ->where('from' ,'>=', request('start_time') )
        //         ->increment('from', "30 minutes");
        $time = request('delay');
        // $query = "update appointments_tb
        // set from_time = ADDTIME(from_time,'12:$time:00')
        // where date = CURDATE()
        // and from_time >= " .  request('start_time') . "and user_id = " . request('id');
        $query = "update appointments_tb";
        $query .= " set from_time = ADDTIME(from_time,'00:$time:00')";
        $query .= " where date = CURDATE() and from_time >= '" . request('start_time') . "' and user_id = " . request('id');
        $users = DB::select($query);
        // return $users;
        // ->update(['from' => 3 , 'to' => 4]);
        return $this->APIResponse(null, null, 201);
    }
    public function change_order_appointment()
    {
        $appointment = Appointment::find(request('appointment_id'));
        // $appointment_after = Appointment::find(request('after_appointment_id'));
        if(isset($appointment))
        {
            $appointments_before =Appointment::where('from_time' ,'<', $appointment->from_time)
            ->where('date' , $appointment->date)->get();
            $durion = (new Carbon($appointment->to_time))->diffInMinutes(new Carbon($appointment->from_time));
            foreach($appointments_before as $appointment_before)
            {

                // return $durion;
              //  $diff_in_minutes = $to->diffInMinutes($from);
              //  print_r($diff_in_minutes); // Output: 20
                $item  =Appointment::find($appointment_before->id);
                if(isset( $item ))
                {
                    $item->from_time = (new Carbon($item->from_time))->addMinutes($durion)->format('H:s:i')  ;
                    $item->to_time = (new Carbon($item->to_time))->addMinutes($durion)->format('H:s:i')  ;
                    $item->save();
                }
                else
                {
                    return $this->APIResponse(null, 'appointments not found', 400);
                }
                
                $appointment->from_time = request('after_time');
                $appointment->to_time =  (new Carbon($appointment->from_time))->addMinutes($durion)->format('H:s:i')  ;
                $appointment->save();
            }
            return $this->APIResponse(null, null, 201);
            // return $appointments_before ;
            // return (new Carbon($appointment->to_time))->diff(new Carbon($appointment->from_time))->format('%h:%I'); addMinutes
            // return $appointment->to_time - $appointment->from_time;
            return $this->APIResponse(\App\Models\Appointment::with(['vistType', 'clinic', 'patient'])
            ->where('user_id', request('id'))
            ->where('date', date('Y-m-d'))
            ->orderBy('from_time')
            ->get(),

            null, 201);
        }
        else
        {
            return $this->APIResponse(null, 'appointments not found', 400);
        }
       
       
    }
    public function getPatientVisit()
    {
        // return \App\Models\PatientVisitModel::all();
        return $this->APIResponse(\App\Models\PatientVisitModel::with(['prescriptionImages', 'patient'])->find(request('id')), null, 201);

    }
    public function sendToken(Request $request)
    {
        $user = UserModel::where("email", $request->email)->first();
        if (isset($user)) {
            $user->remember_token = $fourdigitrandom = rand(1000, 9999);
            $user->save();
            $data['remember_token'] = $user->remember_token;
            $data['email'] = $user->email;
            Mail::send('send_token', $data, function ($message) use ($data) {
                $message->from("contact@u-clinics.com");
                $message->to($data['email']);
                $message->subject('reset password');
            });
            return $this->APIResponse(null, null, 201);
        }
        return $this->APIResponse(null, "not found", 404);

    }
    public function resetPasswotd(Request $request)
    {
        $user = UserModel::where("remember_token", $request->token)->first();
        // return $user;
        if (isset($user)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->APIResponse(null, null, 201);
        }
        return $this->APIResponse(null, "not found", 404);
    }

    public function addOrder()
    {
        \App\Models\PrintingOrder::create([
         'order' => request('order') , 
         'client_id' => request('id'),
         'status' => "لم يتم الرد"
        ]);

        return $this->APIResponse(null, null, 200);
    }

    public function getMeasurements()
    {
        
        return $this->APIResponse(Measurement::where('visit_id' , request('visit_id'))->get(), null, 200);
    }

    public function getAttachments()
    {
        return $this->APIResponse(Attachment::where('visit_id' , request('visit_id'))->get(), null, 200);
    }
}
