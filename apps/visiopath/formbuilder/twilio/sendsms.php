<?php
include("vendor/autoload.php");
$sid = "ACc6a34793fa87ff0c6ed8750800bf6157"; // Your Account SID from www.twilio.com/console
$token = "8733622da705acda1e3874b7fc2ea3ec"; // Your Auth Token from www.twilio.com/console

$client = new Twilio\Rest\Client($sid, $token);
$message = $client->messages->create(
  '+923332499998', // Text this number
  array(
    'from' => 'Visiopath', // From a valid Twilio number
    'body' => 'fahad
	how are you
	03216549'
  )
);

print $message->sid;

