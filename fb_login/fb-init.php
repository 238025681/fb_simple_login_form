<?php

date_default_timezone_set('UTC');

//start the session
session_start();

//include autoload file from vendor folder !!!

require './vendor/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '1329387850532482',
    'app_secret' => '50fbc6b7542af4984595cf78e9425bce',
    'default_graph_version' => 'v2.7'
        ]);

$helper = $fb->getRedirectLoginHelper();
$loginUrl = $helper->getLoginUrl("http://localhost/fb_login/");


try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    // Logged in!
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']
    //if session is set we can redirect to the user to any page
    header("Location:index.php");
} elseif ($helper->getError()) {
    echo 'error';
    exit;
}

//Get users name and email.
if (isset($_SESSION['facebook_access_token'])) {
    try {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        $result = $fb->get('/me?locale=en_US&fields=name,email');
        $user = $result->getGraphUser();
        echo 'Hello, '.$user->getField("name");
    } catch (Exception $ex) {
        echo $ex->getTraceAsString();
    }
}

/*



$loginUrl = $helper->getLoginUrl("http://localhost/fb_login/");


try {
    $accessToken = $helper->getAccessToken();
    var_dump($accessToken);
    if (isset($accessToken)) {
        $_SESSION['access_token'] = (string) $accessToken;

        //if session is set we can redirect to the user to any page
        header("Location:index.php");
    }
} catch (Exception $exc) {
    echo 'error'; // $exc->getTraceAsString();
}
*/