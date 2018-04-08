<?php
//Test Link
//http://localhost/FriendFinderApp/updateLocation.php?uid=2&latitude=23.123&longitude=-56.456

$uid = $_GET["uid"];
$latitude = $_GET["latitude"];
$longitude = $_GET["longitude"];
$status = 'Failed';
$message = '';

if(!($connection = @ mysql_connect("localhost","root","")))
	$message =  "connect failed<br>";

// Select database
if(!(mysql_select_db("friendfinder",$connection)))
  $message =  "select failed<br>\n";
	  
//Check if there is existing username
$query = "UPDATE profile SET Latitude='{$latitude}',Longitude='{$longitude}' WHERE uid='{$uid}'";
$result = @mysql_query($query,$connection);

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