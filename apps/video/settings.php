<?php

//Required Streaming Settings in $options : wsURLWebRTC, applicationWebRTC
//See https://videowhisper.com/?p=Requirements or get a turnkey streaming plan from https://webrtchost.com/hosting-plans/ 

$options = array(
	'wsURLWebRTC' => 'wss://5e06e5e8c2e27.streamlock.net:1936/webrtc-session.json', // * Required
	'applicationWebRTC' => 'demovideowhisper-chat/_definst_', // * Required

	'webrtcVideoCodec' =>'VP8',
	'webrtcAudioCodec' =>'opus',

	'webrtcVideoBitrate' => 750, // demo mode limited to 750kbps, 480p
	'webrtcAudioBitrate' => 64,

	'appSetup' => unserialize('a:1:{s:6:"Config";a:3:{s:19:"cameraAutoBroadcast";s:1:"0";s:14:"cameraControls";s:1:"1";s:13:"videoAutoPlay";s:1:"0";}}'),

	'collaboration' => 0,
	'webKey' => 'VideoWhisper',

	'videochatNext' =>1,

	'tips' => 1,
	'tipOptions' => ''
);

//installation url & integration calls
const VW_H5V_URL = ''; //leave blank if loading from same folder, ex: https://yoursite.com/html5-videochat/
const VW_H5V_CALL = VW_H5V_URL . 'app-call.php?v=1';

//development & debugging
define('VW_DEVMODE', 1);
define('VW_DEVMODE_COLLABORATION', 0);
define('VW_DEVMODE_CLIENT', 0);

if (VW_DEVMODE)
{
	ini_set('display_errors', 1);
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
}
