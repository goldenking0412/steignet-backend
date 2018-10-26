<?php

namespace App\Http\Controllers;

use App\Services\SubmitPropertyService;
use Illuminate\Http\Request;

class SubmitPropertyController extends Controller
{
    private $submitPropertyService;

    public function __construct(SubmitPropertyService $submitPropertyService)
    {
        $this->submitPropertyService = $submitPropertyService;
    }

    public function submitProperty(Request $request)
    {
        $propertyIds = $request->input('propertyIds');
        return $this->submitPropertyService->submitProperty($propertyIds);
    }
}