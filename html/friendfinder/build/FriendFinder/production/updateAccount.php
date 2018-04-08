<?php
//Test Link
//http://localhost/FriendFinder/createAccount.php?username=szhao37&password=qwer&firstname=Sheng&lastname=Zhao&age=21

$uid = $_GET["uid"];
$username = $_GET["username"];
$password = $_GET["password"];
$firstname = $_GET["firstname"];
$lastname = $_GET["lastname"];
$age = $_GET["age"];
$status = 'Failed';
$message = '';

if(!($connection = @ mysql_connect("localhost","root","")))
	$message =  "connect failed<br>";

// Select database
if(!(mysql_select_db("friendfinder",$connection)))
  $message =  "select failed<br>\n";
	  
//Check if there is existing username
$query = "UPDATE profile SET Username='{$username}',Password='{$password}',FirstName='{$firstname}',LastName='{$lastname}',Age='{$age}' WHERE uid='{$uid}'";
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