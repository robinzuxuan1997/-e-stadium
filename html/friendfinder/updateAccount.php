<?php
//Test Link
//http://localhost/FriendFinder/createAccount.php?username=szhao37&password=qwer&firstname=Sheng&lastname=Zhao&age=21
/*
$uid = 10;
$username = "mcarle15";
$password = "friendfinder";
$firstname = "Matthew";
$lastname = "Carle";
$age = "21";
*/
include("db/dbAccess.php");
$uid = $_GET["uid"];
$username = $_GET["username"];
$password = $_GET["password"];
$firstname = $_GET["firstname"];
$lastname = $_GET["lastname"];
$age = $_GET["age"];
$status = 'Failed';
$message = '';

$result = DB::updateAccount($username, $password, $firstname, $lastname, $age, $uid);

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
