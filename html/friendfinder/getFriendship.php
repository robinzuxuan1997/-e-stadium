<?php
include("db/dbAccess.php");
/*
$userid = $_GET["userid"];
*/
$userid = '1';
$status = 'Failed';
$message = '';
$arr = array();
$result = DB::getFriendship($userid);
while($row = mysqli_fetch_array($result))
{
	$person = getUserInfo($row['FriendID']);
	array_push($arr,$person);
}
echo json_encode($arr);

function getUserInfo($uid)
{
	$result = DB::getUserInfo($uid);
	$row = mysqli_fetch_array($result);
	$ret = array(
			 'uid' => $row['uid'],
			 'firstname' => $row['FirstName'],
			 'lastname' => $row['LastName'],
			 'age' => $row['Age'],
			 'lat' => $row['Latitude'],
			 'lng' => $row['Longitude'],
			 'logtime' => $row['LogTime']
			 );
	return $ret;
}
  
?>
