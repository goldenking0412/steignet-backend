<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Aws\Laravel\AwsFacade as AWS;
use Aws\Laravel\AwsServiceProvider;

class FileController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function readFileFromStorage($bucket, $keyname)
    {
        $s3 = AWS::createClient('s3');

        $result = $s3->getObject([
            'Bucket' => $bucket,
            'Key'    => $keyname
        ]);

        /*Remove last break line character*/
        $result['Body'] = rtrim($result['Body'], '\n');

        return $result['Body'];
    }
}
