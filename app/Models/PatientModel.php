<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\DrugModel;
use App\Models\LabModel;
use App\Models\RayModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Log;
class PatientModel extends Model
{
    protected $table= 'patient_tb';

    protected $fillable = [
        'full_name','email','tel','address','social_status','ssn','user_id','active' ,'client_id','gender'];
    
    public function visit()
    {
        return $this->hasOne(PatientVisitModel::class , 'patient_id');
    }
    public function visits()
    {
        return $this->hasMany(PatientVisitModel::class , 'patient_id');
    }
    public function visitCount()
    {
        return $this->visits->count();
    }
    public static function getAllPatients()
    {
        $query = "select p.id, p.full_name, p.email , p.tel, p.address , p.social_status ,p.ssn , c.clinic_name,c.doctor_full_name 
        from patient_tb as p, client_tb as c ";
        $query .= "where c.id = p.client_id and p.active = 1 ";
        		//and l.end_on > c.created_at
        $clients = DB::select($query);
        return $clients;

    }    

    public static function api_update_patient($client_id)
    {
        $patients = Input::get('patients');
//print_r($patients[0][0]);
        foreach ($patients as $value)
        {

            $existPatient = PatientModel::where([
                            ['full_name', $value['full_name']],
                            ['ssn', $value['ssn']]])->first();
            if(!$existPatient)
            {
                $patientRow = array(
                    'full_name' =>$value['full_name'],
                    'email' => $value['email'],
                    'tel' => $value['tel'],
                    'gender' => $value['gender'],
                    'address' => $value['address'], 
                    'social_status' => $value['social_status'],
                    'ssn' => $value['ssn'],
                    'client_id'=> $client_id
                );
                $patientRow = PatientModel::create($patientRow);
            }
        }
    }

     public static function get_patients_after_datetime($data_last_updated)
    {
        $query = "select full_name , email , tel , gender , address , social_status , ssn  ";
        $query .= "from patient_tb ";
        $query .= "where created_at > '$data_last_updated' and active = 1 ";
        $results = DB::select($query);
        
        $counter = 0; 
        $patients;
        // var_dump($results);
        foreach ($results as $key=>  $value) 
        {
            $patients[$counter]['full_name'][$key] = $value->full_name;
            $patients[$counter]['email'][$key] = $value->email;
            $patients[$counter]['tel'][$key] = $value->tel;
            $patients[$counter]['gender'][$key] = $value->gender;
            $patients[$counter]['address'][$key] = $value->address;
            $patients[$counter]['social_status'][$key] = $value->social_status;
            $patients[$counter]['ssn'][$key] = $value->ssn;
            $counter++;
        }
        return $patients;    
    }

    public static function savePatient()
    {
        $patient = new PatientModel;
        $patient->full_name = Input::get('full_name');
        $patient->email = Input::get('email');
        $patient->tel = Input::get('tel');
        $patient->address = Input::get('address');
        $patient->social_status = Input::get('social_status');
        $patient->ssn = Input::get('ssn');
        $patient->gender = Input::get('gender');
        $patient->user_id = Auth::user()->id; 
        $patient->client_id = Auth::user()->id; 
        $patient->save();
    }

    public static function update_patient($patientId)
    {
        $patient = PatientModel::find($patientId);
        $patient->full_name = Input::get('full_name');
        $patient->email = Input::get('email');
        $patient->tel = Input::get('tel');
        $patient->address = Input::get('address');
        $patient->social_status = Input::get('social_status');
        $patient->ssn = Input::get('ssn');
        $patient->gender = Input::get('gender');
        
        $patient->save();
    }

    public function deactivate(){
        $this->active = 0;
        $this->user_id = Auth::id();
        $this->save();
    }

    public static function store_patient()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $check = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);
        Log::info($_POST);
        Log::info($check);

        if($check)
        {
            $patients = Input::get('patients');
            $patient = new PatientModel;
            $patient->full_name = $patients['full_name'];
            $patient->email = $patients['email'];
            $patient->tel = $patients['tel'];
            $patient->client_pk_value = Input::get('id');
            $patient->address = $patients['address'];
            $patient->social_status = $patients['social_status'];
            $patient->ssn = $patients['ssn'];
            $patient->gender = $patients['gender'];
            $patient->client_id = $licence_serial_no;
            $patient->save();
            $return = [];
            $return['success'] = true;
            $return['data']=[];
            
            echo json_encode($return);
            return;
        }
        $return = [];
        $return['success'] = false;
        $return['data']=[];
        echo json_encode($return);
    }

    public static function search_patient()
    {
        $MACAddress = Input::get('MacAddress');
        $user_name = Input::get('user_name');
        $licence_serial_no = Input::get('licence_serial_no');
        $ssn = Input::get('ssn');

        $isExists = ClientModel::check_existing_client($MACAddress,$user_name,$licence_serial_no);

        if($isExists)
        {
            $patient = PatientModel::where('ssn', $ssn)->first();

            if(!empty($patient))
            {
                $return = [];
                $return['success'] = true;
                $return['data']=[$patient];
            }else
            {
                $return = [];
                $return['success'] = false;
                $return['data']=[];
            }

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
