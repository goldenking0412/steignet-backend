<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function getMaster()
    {
        $bucket = 'steignet-mls-data';
        $keyname = 'AVM/Master Inventory.csv';

        return FileController::readFileFromStorage($bucket, $keyname);
    }
}
