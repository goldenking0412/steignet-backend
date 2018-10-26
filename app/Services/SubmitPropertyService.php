<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SubmitPropertyService
{
    public function submitProperty($data){
        $insertAmount = 0;
        $foundInView = 0;

        try {
            foreach ($data as $propertyId) {
                //find in construction_listing_view
                if ($viewProperty = DB::table('construction_listing_view')
                    ->where('Property_ID', $propertyId)
                    ->first()){
                    $foundInView ++;
                    if(!$property = DB::table('construction_app_properties')
                        ->where('id', $propertyId)
                        ->first()){

                        //insert in construction_app_properties
                        DB::table('construction_app_properties')->insert(
                            [
                                'id' => $viewProperty->Property_ID,
                                'mls' => $viewProperty->ListingSourceID,
                                'type_id' => $viewProperty->PropertySubType
                            ]
                        );
                        $insertAmount ++;
                    }
                }
            }

            if($insertAmount){
                return response()->json([
                    'result' => 'success',
                    'message' => 'Found ' . $foundInView . ' properties and ' . $insertAmount . ' add into database',
                ], 200);
            } else {
                return response()->json([
                    'result' => 'error',
                    'message' => 'Found ' . $foundInView . ' properties and ' . $insertAmount . ' add into database',
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'result' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}