<?php
$username = $_GET["username"];
$password = $_GET["password"];

if(!($connection = @ mysql_connect("localhost","root","")))
  echo "connect failed<br>";

// Select database
if(!(mysql_select_db("friendfinder",$connection)))
  echo "select failed<br>\n";

$query = "SELECT * FROM profile WHERE Username='{$username}' AND Password='{$password}'";
//echo $query;
$result = @mysql_query($query,$connection);

if ( (! $result) || (!($row=mysql_fetch_array($result))) )
{
	//Bad login information
	$ret = array('status' => 'Failed','message' => 'Invalid username or password');
	echo json_encode($ret);
}
else
{
	$result = @mysql_query($query,$connection); //re-query
	$row = mysql_fetch_array($result);
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