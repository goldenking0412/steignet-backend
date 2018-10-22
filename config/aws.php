<?php

use Aws\Laravel\AwsServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. The minimum
    | required options are declared here, but the full set of possible options
    | are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */

    'credentials' => [
        'key'       => 'AKIAI4NNJVG6LALDBMRQ',
        'secret'    => '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',
    ],
    'region' => 'us-east-2',
    'version' => 'latest',

    /*'Ses' => [
        'region' => 'us-east-1',
    ],*/
];
