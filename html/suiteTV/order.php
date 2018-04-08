<html>	
    <head>
        <link rel="stylesheet" href="style.css"/>
	<script type="text/javascript" src="clicktable.js"></script>
        <title>SuiteTV Food Orders</title>
    </head>
    <body>
	    <center>
	    <h1> SuiteTV Food Orders</h1>
	
	    <?php
                foreach($_GET as $x => $value)
                {
                    $id = $value;  /*store username into $searchname*/
                }
                
		//Connect to the MySQL server
		    if(!($connection = @ mysql_connect("eugene.vip.gatech.edu",test,"1234")))
			echo "connect failed<br>";
		    
		    // Select database
		    if(!(mysql_select_db("test",$connection)))
			echo "db select failed<br>\n";
	    
		    $query = "SELECT * FROM `orderscart` WHERE orderid = '{$id}'";
	    
		    //Query the database
	    
		    if(!($result = @ mysql_query($query,$connection)))
			echo "query failed<br>";
	    
		    echo '<table id="main">';
		    echo '<tr><th>OrderID</th><th>Item Name</th><th>Item Cost</tr>';	
		    while($row = mysql_fetch_array($result))
		    {
			echo '<tr>';
			echo '<td>',$row["orderid"],'</td>';
			echo '<td>',$row["foodname"],'</td>';
			echo '<td>',$row["cost"],'</td>';
			echo '</tr>';
		    }
		    echo '</table>';
	
	?>
            <form action="index.php" method="GET">
            <input type="submit" value="Go Back">
	    </form>
            
	    </center>
    </body>	
</html>