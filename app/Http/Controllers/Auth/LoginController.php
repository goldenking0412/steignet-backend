<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Aws\Laravel\AwsFacade as AWS;
use Aws\Laravel\AwsServiceProvider;
use Illuminate\Container\Container;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $req)
    {
        if ($req->username === "admin" && $req->password === "admin123")
            return response("success");
        return response("incorrect");
    }

    public function load()
    {
        $bucket = 'steignet-mls-data';
        $keyname = 'AVM/All.csv';

        $s3 = AWS::createClient('s3');

        $result = $s3->getObject([
            'Bucket' => $bucket,
            'Key'    => $keyname
        ]);

        header("Content-Type: {$result['ContentType']}");
        echo $result['Body'];
    }
}
