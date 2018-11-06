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
use App\ListingView;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function SearchData(Request $request){

        ini_set('memory_limit','-1');

        $type = $request->input('type');
        if($type == 'deattach')
            $type_value = '1676';
        else
            $type_value = '1677';

        $result = ListingView::where('PropertyType','=',$type_value);
        
        // $result = $result->leftjoin('property','listing.Property_ID','=','property.id');
        // $result = $result->leftjoin('enumerations','listing.MlsStatus','=','enumerations.id');
        
        $total_bedroom = $request->input('total_bedroom');
        if($total_bedroom != ''){
            if(strpos($total_bedroom,'+') !== false)
                $result = $result->where('bedroomtotal','>=',$total_bedroom);
            else if(strpos($total_bedroom,'-') !== false)
            {
                $temp = explode('-',$total_bedroom);
                if($temp[1] == "")
                    $result = $result->where('bedroomtotal','<=',$temp[0]);
                else
                    $result = $result->where('bedroomtotal','>=',$temp[0])->where('bedroomtotal','<=',$temp[1]);
            }
            else
                $result = $result->where('bedroomtotal','=',$total_bedroom);

        }

        $total_bathroom = $request->input('total_bathroom');
        if($total_bathroom != ''){
            if(strpos($total_bathroom,'+') !== false)
                $result = $result->where('bathroomsfull','>=',$total_bathroom);
            else if(strpos($total_bathroom,'-') !== false)
            {
                $temp = explode('-',$total_bathroom);
                if($temp[1] == "")
                    $result = $result->where('bathroomsfull','<=',$temp[0]);
                else
                    $result = $result->where('bathroomsfull','>=',$temp[0])->where('bathroomsfull','<=',$temp[1]);
            }
            else
                $result = $result->where('bathroomsfull','=',$total_bathroom);
            
        }

        $sqFt = $request->input('sqft');
        if($sqFt != ''){
            if(strpos($sqFt,'+') !== false)
                $result = $result->where('livingarea','>=',$sqFt);
            else if(strpos($sqFt,'-') !== false)
            {
                $temp = explode('-',$sqFt);
                if($temp[1] == "")
                    $result = $result->where('livingarea','<=',$temp[0]);
                else
                    $result = $result->where('livingarea','>=',$temp[0])->where('livingarea','<=',$temp[1]);
            }
            else
                $result = $result->where('livingarea','=',$sqFt);
        }

        $years_built = $request->input('yearbuilt');
        if($years_built != ''){
            if(strpos($years_built,'+') !== false)
                $result = $result->where('yearbuilt','>=',$years_built);
            else if(strpos($years_built,'-') !== false)
            {
                $temp = explode('-',$years_built);
                if($temp[1] == "")
                    $result = $result->where('yearbuilt','<=',$temp[0]);
                else
                    $result = $result->where('yearbuilt','>=',$temp[0])->where('yearbuilt','<=',$temp[1]);
            }
            else
                $result = $result->where('yearbuilt','=',$years_built);
        }
        $price = $request->input('price');
        if($price != ''){
            if(strpos($price,'+') !== false)
                $result = $result->where('listprice','>=',$price);
            else if(strpos($price,'-') !== false)
            {
                $temp = explode('-',$price);
                if($temp[1] == "")
                    $result = $result->where('listprice','<=',$temp[0]);
                else
                    $result = $result->where('listprice','>=',$temp[0])->where('listprice','<=',$temp[1]);
            }
            else
                $result = $result->where('listprice','=',$price);
            
        }
        $listsourceid = $request->input('listsourceid');
        if($listsourceid != '')
            $result = $result->where('ListingSourceID','=',$listsourceid);
        $private_remark = $request->input('private_remark');
        if($private_remark != ''){
            $temp = explode(',',$private_remark);
            for($i = 0; $i < count($temp); $i++){
                $ttemp = str_replace('*','',$temp[i]);
                $result = $result->where('PrivateRemarks','like','%'.$ttemp.'%');
            }
        }
        $public_remark = $request->input('public_remark');
        if($public_remark != ''){
            $temp = explode(',',$public_remark);
            for($i = 0; $i < count($temp); $i++){
                $ttemp = str_replace('*','',$temp[i]);
                $result = $result->where('PublicRemarks','like','%'.$ttemp.'%');
            }
        }

        // $within = $request->input('within');
        // if($total_bedroom != '')
        //     $result = $result->where('BedroomsTotal','=',$total_bedroom);
        // $milesof = $request->input('milesof');
        // if($total_bedroom != '')
        //     $result = $result->where('BedroomsTotal','=',$total_bedroom);
        $country = $request->input('country');
        if($country != '')
            $result = $result->where('CountyOrParish','=',$country);

        $area = $request->input('area');
        if($area != '')
            $result = $result->where('MLSAreaMajor','=',$area);
        $city = $request->input('city');
        if($city != '')
            $result = $result->where('City','=',$city);
        $subdivision = $request->input('subdivision');
        if($subdivision != '')
            $result = $result->where('StateOrProvince','=',$subdivision);
        $zipcode = $request->input('zipcode');
        if($zipcode != '')
            $result = $result->where('PostalCode','=',$zipcode);
        $streetnumber = $request->input('streetnumber');
        if($streetnumber != '')
            $result = $result->where('streetnumber','=',$streetnumber);
        $dirpix = $request->input('dirpix');
        if($dirpix != '')
            $result = $result->where('streetdirprefix','=',$dirpix);
        $streetname = $request->input('streetname');
        if($streetname != '')
            $result = $result->where('streetname','=',$streetname);
        $st_sfx = $request->input('st_sfx');
        if($st_sfx != '')
            $result = $result->where('streetsuffix','=',$st_sfx);
        $dir_sfx = $request->input('dir_sfx');
        if($dir_sfx != '')
            $result = $result->where('streetdirsuffix','=',$dir_sfx);
        $unitnumber = $request->input('unitnumber');
        if($unitnumber != '')
            $result = $result->where('unitnumber','=',$unitnumber);

        $elementschool = $request->input('elementschool');
        if($elementschool != '')
            $result = $result->where('elementaryschool','=',$elementschool);
        $middleschool = $request->input('middleschool');
        if($middleschool != '')
            $result = $result->where('middleschool','=',$middleschool);
        $highschool = $request->input('highschool');
        if($highschool != '')
            $result = $result->where('highschool','=',$highschool);

        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        if($status != ''){
            if($status == 'Acitve'){
                $result = $result->where('listingcontractdate','>=',$start_date)->where('listingcontractdate','<=',$end_date);
            }
            else if($status == 'Active Under Contract'){
                $result = $result->where('offmarketdate','>=',$start_date)->where('offmarketdate','<=',$end_date);
            }
            else if($status == 'Canceled'){
                $result = $result->where('statuschangetimestamp','>=',$start_date)->where('statuschangetimestamp','<=',$end_date);
            }
            else if($status == 'Closed'){
                $result = $result->where('closeddate','>=',$start_date)->where('closeddate','<=',$end_date);
            }
            else if($status == 'Coming Soon'){
                $result = $result->where('statuschangetimestamp','>=',$start_date)->where('statuschangetimestamp','<=',$end_date);
            }
            else if($status == 'Delete'){
                $result = $result->where('statuschangetimestamp','>=',$start_date)->where('statuschangetimestamp','<=',$end_date);
            }
            else if($status == 'Expired'){
                $result = $result->where('expirationdate','>=',$start_date)->where('expirationdate','<=',$end_date);
            }
            else if($status == 'Hold'){
                $result = $result->where('statuschangetimestamp','>=',$start_date)->where('statuschangetimestamp','<=',$end_date);
            }
            else if($status == 'Incomplete'){
                $result = $result->where('statuschangetimestamp','>=',$start_date)->where('statuschangetimestamp','<=',$end_date);
            }
            else if($status == 'Pending'){
                $result = $result->where('pendingtimestamp','>=',$start_date)->where('pendingtimestamp','<=',$end_date);
            }
            else if($status == 'Withdrawn'){
                $result = $result->where('withdrawndate','>=',$start_date)->where('withdrawndate','<=',$end_date);
            }
        }

        $result = $result->select('BathroomsFull','BedroomsTotal','City','ListPrice','ListingSource','ListingSourceID','MlsStatus','OriginalListPrice','PreviousListPrice','UnitNumber','UnparsedAddress','Zestimate_AVM','Redfin_AVM','yearbuilt','SubdivisionName','livingarea','TaxBookNumber','ListingContractDate')->get();
        

        return json_encode($result);
    }
}
