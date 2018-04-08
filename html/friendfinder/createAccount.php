<?php
//Test Link
//http://localhost/FriendFinder/createAccount.php?username=szhao37&password=qwer&firstname=Sheng&lastname=Zhao&age=21
include("db/dbAccess.php");
$username = $_GET["username"];
$password = $_GET["password"];
$firstname = $_GET["firstname"];
$lastname = $_GET["lastname"];
$age = $_GET["age"];

/*
$username = 'datatest2';
$password = 'tester';
$firstname = 'matt';
$lastname = 'carle';
$age = '72';
*/
$status = 'Failed';
$message = '';

if (strlen($username) < 4)
{
	$message =  "Username too short";
} 
else if (strlen($password) < 4)
{
	$message =  "Password too short";
} 
else // valid account
{	  
	$result = DB::checkUserExists($username);

	if ( (! $result) || (!($row=mysqli_fetch_array($result))) )
	{
		//no existing account, so create one
		$result = DB::addNewAcct($username, $password, $firstname, $lastname, $age, $status, $message);
		if ($result)
		{
			$status = 'success';
		} 
		else 
		{
			$status = 'failed';
		}
	} 
	else 
	{
		//user exists
		$message = "Already Exist";
	}
}

$ret = array('status'=>$status,'message'=>$message);
echo json_encode($ret);

?>
