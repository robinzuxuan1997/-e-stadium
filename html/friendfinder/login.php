<?php
// usrname and pwd passed from form
$username = $_GET["username"];
$password = $_GET["password"];

include("db/dbAccess.php");


$result = DB::checkLogin($username, $password);

if ( (! $result) || (!($row=mysqli_fetch_array($result))) )
{
	//Bad login information
	$ret = array('status' => 'Failed','message' => 'Invalid username or password');
	echo json_encode($ret);
}
else
{        
	$ret = array('status' => 'success',
				'accountInfo' => array(
									 'uid' => $row['uid'],
									 'username' => $row['Username'],
									 'password' => $row['Password'],
									 'firstname' => $row['FirstName'],
									 'lastname' => $row['LastName'],
									 'age' => $row['Age']
									 )
				);
	
	echo json_encode($ret);
}
?>
