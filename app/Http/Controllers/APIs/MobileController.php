<?php

namespace App\Http\Controllers\APIs;
use App\Http\Controllers\APIResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Auth;
class MobileController extends Controller
{
    use APIResponseTrait;

    public function countries()
    {
        return $this->APIResponse(\App\Models\CountryModel::with('cities.towns')->get(), null, 201);
    }
    public function cities()
    {
        return $this->APIResponse(\App\Models\CityModel::all(), null, 201);
    }
    public function towns()
    {
        return $this->APIResponse(\App\Models\TownModel::all(), null, 201);
    }
    public function specials()
    {
        return $this->APIResponse(\App\Models\SpecialistModel::all(), null, 201);
    }
    public function showOffers()
    {
        return $this->APIResponse(\App\Models\Offer::all(), null, 201);
    }
    public function externalLinks()
    {
        return $this->APIResponse(\App\Models\ExternalLinksModel::all(), null, 201);
    }
    public function pref()
    {
        $data['prefs'] = \App\Models\PrefModel::all() ; 
        $data['externalLinks'] = \App\Models\ExternalLinksModel::all();
        return $this->APIResponse($data, null, 201);
    }
    public function contact(Request $request)
    {
        return $this->APIResponse(null, null, 201);
    }
    public function visit_types($clinic_id)
    {
        return $this->APIResponse(\App\Models\VisitType::where('clinic_id' , $clinic_id)->get(), null, 201);
    }

}
