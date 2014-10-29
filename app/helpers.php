<?php

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

function getLocale() {
    return App::getLocale();
}

function getClientIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

return getApiContext();

// SDK Configuration
function getApiContext() {


    // Define the location of the sdk_config.ini file
//    define("PP_CONFIG_PATH", dirname(__DIR__));

    $apiContext = new ApiContext(new OAuthTokenCredential(
        'AcDMFxAK6Ni4b4kZZ0Kmvs1zOjAUT_5D-FP8xGrTIGoYrDg8wHOEjDTmegf0',
        'EMCKfRBXwjNQN3VV_gzvafd3QqHSxuA1t0nJ1fCdECph5FBzwH_78n-qp9qr'
    ));


    // Alternatively pass in the configuration via a hashmap.
    // The hashmap can contain any key that is allowed in
    // sdk_config.ini

    $apiContext->setConfig(array(
        'http.ConnectionTimeOut' => 30,
        'http.Retry' => 1,
        'mode' => 'sandbox',
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'INFO'
    ));

    return $apiContext;
}