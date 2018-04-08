<?php
mysql_connect("localhost","estad","V!p_f09") or die(mysql_error());
mysql_select_db("estadium") or die(mysql_error());

$result = mysql_query("SELECT * FROM site_usage WHERE 2009-11-04") or die(mysql_error());
echo"<table border = '1'>";
echo "<tr><th>Name</th><th>Age</th></tr>";
while($row = mysql_fetch_array($result)){
:
