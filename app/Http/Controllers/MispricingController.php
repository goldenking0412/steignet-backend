<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Steignetdata;
use App\Craglist;
use App\SecretKey;
use App\MasterInventory;
use App\Listing;
use App\Property;
use DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Route;


class MispricingController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function MisPricing(){
        $result = Property::join('listing','property.id','=','listing.property_id')
                        ->join('AVM','property.id','=','AVM.property_id')
                        ->select('AVM.avm_value','listing.ListPrice',DB::raw('((AVM.avm_value - listing.ListPrice)/listing.Listprice)*100 as delta'),'listing.listingsource','date_retreived')
                        ->where('AVM.avm_value','>',0)
                        ->where('AVM.avm_value','>','listing.Listprice')
                        ->get();
        return $result;
    }

}
