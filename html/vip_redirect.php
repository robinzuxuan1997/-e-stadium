<?php
include('mobile_device_detect.php');
$server_name = $_SERVER['SERVER_NAME'];
$mobile_folder = '/iphone/'; //change me to a different folder

$redirect_me_here = 'http://'.$server_name.$mobile_folder;

// parameters : $iphone=true,$android=true,$opera=true,$blackberry=true,$palm=true,$windows=true,$mobileredirect=false,$desktopredirect=false
mobile_device_detect($redirect_me_here, $redirect_me_here, $redirect_me_here, false,$redirect_me_here ,false ,false ,false);
