<?php
	$host = "143.215.249.135";
	$user = "estad";
	$pass = "V!p_f09";
	//$db_name = "estadium";
	//Connect
	$conn = mysql_connect($host, $user, $pass) or die("Could not connect");
	//$db = mysqli_select_db($conn, $db_name) or die("Could not connect");


	$sql = "SELECT SeasonID, Game.ID, Name, Acronym, Logo_Path
			FROM `Game` 
			JOIN `Team` ON VisitorID = Team.ID
			ORDER BY SeasonID DESC , Game.ID DESC";
	$result = mysql_query($conn, $sql);
	$out = array();

	while ($row = mysql_fetch_assoc($result)) {
		
	    $out["Games"][] = $row;
	}
	echo json_encode($out);
?>