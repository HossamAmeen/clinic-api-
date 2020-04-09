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
        return $this->APIResponse(\App\Models\CountryModel::get(), null, 201);
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
        return $this->APIResponse(\App\Models\PrefModel::all(), null, 201);
    }
    public function contact(Request $request)
    {
        return $this->APIResponse(null, null, 201);
    }
    
}
