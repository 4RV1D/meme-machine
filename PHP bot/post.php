<?php

require 'vendor/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

$appId      = "";
$appSecret  = "";

$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.2',
  ]);

$msg = [
  'message' => 'Radical dude',
];

$access_token = $fb->getAccessToken();

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/me/feed', $msg, $access_token);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphNode = $response->getGraphNode();

echo 'Posted with id: ' . $graphNode['id'];

/*$facebook = new Facebook\Facebook([
  'appId'  => $appId,
  'secret' => $appSecret,
  'cookie' => true
]);

$token  = $facebook->getAccessToken();
$msg    = "Radical dude!";
$title  = "Yo";
$uri    = "";
$desc   = "";
$pic    = "https://scontent.xx.fbcdn.net/v/t1.0-9/18555864_473563096309318_1153995997627697899_n.jpg?oh=bde143bcac7fa63f4637fe213f0bf8ac&oe=59B182CB";

$attachment =  array(
  'access_token' => $token,
  'message' => $msg,
  'name' => $title,
  'link' => $uri,
  'description' => $desc,
  'picture'=>$pic,
  'actions' => json_encode(array('name' => $action_name,'link' => $action_link))
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/johan.wiberg.102/feed');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
$result = curl_exec($ch);
curl_close ($ch);*/
