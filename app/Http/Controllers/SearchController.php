<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Steignetdata;
use App\Listing;
use App\Property;
use App\Enumeration;


class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function SearchData(Request $request){

        $type = $request->input('type');
        if($type == 'deattach')
            $type_value = '1677';
        else
            $type_value = '1676';

        $result = Listing::where('PropertyType','=',$type_value)->limit(100);
        $result = $result->get();
        
        return $result;
        
        $result = $result->leftjoin('property','listing.Property_ID','=','property.id');
        $result = $result->leftjoin('enumerations','listing.MlsStatus','=','enumerations.id');
        
        $total_bedroom = $request->input('total_bedroom');
        if($total_bedroom != '')
            $result = $result->where('listing.BedroomsTotal','=',$total_bedroom);

        $total_bathroom = $request->input('total_bathroom');
        if($total_bathroom != '')
            $result = $result->where('listing.BathroomsFull','=',$total_bathroom);

        $sqFt = $request->input('sqft');
        // if($sqFt != '')
        //     $result = $result->where('BedroomsTotal','=',$sqFt);
        $years_built = $request->input('yearbuilt');
        if($years_built != '')
            $result = $result->where('listing.Created_DT','like','%'.$years_built.'%');
        $price = $request->input('price');
        if($price != '')
            $result = $result->where('listing.ListPrice','=',$price);
        $listsourceid = $request->input('listsourceid');
        if($listsourceid != '')
            $result = $result->where('listing.ListingSourceID','=',$listsourceid);
        $private_remark = $request->input('private_remark');
        if($private_remark != '')
            $result = $result->where('listing.PrivateRemarks','=',$private_remark);
        $public_remark = $request->input('public_remark');
        if($public_remark != '')
            $result = $result->where('listing.PublicRemarks','=',$public_remark);

        // $within = $request->input('within');
        // if($total_bedroom != '')
        //     $result = $result->where('BedroomsTotal','=',$total_bedroom);
        // $milesof = $request->input('milesof');
        // if($total_bedroom != '')
        //     $result = $result->where('BedroomsTotal','=',$total_bedroom);
        $country = $request->input('country');
        if($country != '')
            $result = $result->where('property.Country','=',$country);

        $area = $request->input('area');
        if($area != '')
            $result = $result->where('property.SubdivisionName','=',$area);
        $city = $request->input('city');
        if($city != '')
            $result = $result->where('property.City','=',$city);
        $subdivision = $request->input('subdivision');
        if($subdivision != '')
            $result = $result->where('property.StateOrProvince','=',$subdivision);
        $zipcode = $request->input('zipcode');
        if($zipcode != '')
            $result = $result->where('property.PostalCode','=',$zipcode);
        $streetnumber = $request->input('streetnumber');
        if($streetnumber != '')
            $result = $result->where('property.StreetNumber','=',$streetnumber);
        $dirpix = $request->input('dirpix');
        if($dirpix != '')
            $result = $result->where('property.StreetDirPrefix','=',$dirpix);
        $streetname = $request->input('streetname');
        if($streetname != '')
            $result = $result->where('property.StreetName','=',$streetname);
        $st_sfx = $request->input('st_sfx');
        if($st_sfx != '')
            $result = $result->where('property.StreetSuffix','=',$st_sfx);
        $dir_sfx = $request->input('dir_sfx');
        if($dir_sfx != '')
            $result = $result->where('property.StreetDirSuffix','=',$dir_sfx);
        $unitnumber = $request->input('unitnumber');
        if($unitnumber != '')
            $result = $result->where('property.UnitNumber','=',$unitnumber);

        // $elementschool = $request->input('elementschool');
        // if($elementschool != '')
        //     $result = $result->where('BedroomsTotal','=',$elementschool);
        // $middleschool = $request->input('middleschool');
        // if($middleschool != '')
        //     $result = $result->where('BedroomsTotal','=',$middleschool);
        // $highschool = $request->input('highschool');
        // if($highschool != '')
        //     $result = $result->where('BedroomsTotal','=',$highschool);
        $status = $request->input('status');
        if($status != '')
             $result = $result->where('enumerations.LookupValue','=',$status);

        $result = $result->get();
        

        return $result;
    }
}
