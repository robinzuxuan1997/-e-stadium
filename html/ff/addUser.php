<?php
	// usrname and pwd passed from form
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$age = $_POST["age"];
	$username = $_POST["usrName"];
	$password = $_POST["pwd"];

	include("db/dbAccess.php");

	// check if user is already in database
	if(mysqli_num_rows(DB::getUser($username)) > 0){
		// username already exists!
		$ret = array('status' => 'failed', 'message' => 'User already exists');
		echo json_encode($ret);
		exit;
	}

	// username is valid, create user
	if(!DB::addNewUser($fname, $lname, $age, $username, crypt($password))){
		$ret=array('status' => 'failed', 'message' => 'INTERNAL ERROR');
		echo json_encode($ret);
	}
	else{
		$ret = array('status' => 'success', 'message' => 'User added successully!');
		echo json_encode($ret);
	}
?>