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
use App\AVM_Checker;
use DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Route;


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
    public function SteignetData(){
        $result = Steignetdata::get();
        return $result;
    }

    public function CraglistData(){
        $result = Craglist::get();
        return $result;
    }

    public function PassThrough(){
        $constructionApp = SecretKey::where('name', '=', 'constructionApp')->first()->value;
        $encryptionKey = SecretKey::where('name', '=', 'encryptionKey')->first()->value;
        $algorithmEncryption = SecretKey::where('name', '=', 'algorithmEncryption')->first()->value;
        $crypt = new Encrypter($encryptionKey, $algorithmEncryption);
        $url = 'http://construction.steignet.com/authentication/'.$crypt->encrypt($constructionApp);
        return $url;
    }

    public function Master_inventory(){
        $result = MasterInventory::get();
        return $result;
    }

    public function AVMChecker(){
        $result = AVM_Checker::get();
        return $result;
    }
}
