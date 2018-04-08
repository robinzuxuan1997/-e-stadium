<?php
//Test Link
//http://localhost/FriendFinder/createAccount.php?username=szhao37&password=qwer&firstname=Sheng&lastname=Zhao&age=21

$username = $_GET["username"];
$password = $_GET["password"];
$firstname = $_GET["firstname"];
$lastname = $_GET["lastname"];
$age = $_GET["age"];
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
	if(!($connection = @ mysql_connect("localhost","root","")))
	  $message =  "connect failed<br>";

	// Select database
	if(!(mysql_select_db("friendfinder",$connection)))
	  $message =  "select failed<br>\n";
	  
	//Check if there is existing username
	$query = "SELECT * FROM profile WHERE Username='{$username}'";
	$result = @mysql_query($query,$connection);

	if ( (! $result) || (!($row=mysql_fetch_array($result))) )
	{
		//no existing account, so create one
		$insert = "INSERT INTO profile (Username,Password,FirstName,LastName,Age) " .
				"VALUES ('{$username}','{$password}','{$firstname}','{$lastname}',{$age})";
		$result = @mysql_query($insert,$connection);
		
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