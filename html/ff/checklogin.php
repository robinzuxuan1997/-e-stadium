<?php
// usrname and pwd passed from form
$username = $_GET["usrName"];
$password = $_GET["pwd"];

include("db/dbAccess.php");


$user = DB::getUser($username, $password);

if ( (! $result) || (!($row=mysqli_fetch_array($result))) )
{
	//Bad login information
	$ret = array('status' => 'Failed','message' => 'Invalid username or password');
	echo json_encode($ret);
}
else
{        
}
?>
