<?php
//Test Link
//http://localhost/FriendFinderApp/updateLocation.php?uid=2&latitude=23.123&longitude=-56.456
include("db/dbAccess.php");
$uid = $_GET["uid"];
$latitude = $_GET["latitude"];
$longitude = $_GET["longitude"];
$logtime = $_GET["logtime"];
$status = 'Failed';
$message = '';

//Check if there is existing username
$result = DB::updateLocation($latitude, $longitude, $logtime, $uid);

if ($result)
{
	$status = 'success';
	$message = 'updated';
} 
else 
{
	$status = 'failed';
	$message = 'failed to update';
}


$ret = array('status'=>$status,'message'=>$message);
echo json_encode($ret);

?>
