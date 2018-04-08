<html>	
    <head>
        <link rel="stylesheet" href="style.css"/>
	<script type="text/javascript" src="clicktable.js"></script>
        <title>SuiteTV Food Orders</title>
    </head>
    <body>
	    <center>

	
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
	    
		    $query = "UPDATE `orders` SET delivered='Yes' WHERE id = '{$id}'";
	    
		    //Query the database
		    if(!($result = @ mysql_query($query,$connection)))
			echo "query failed<br>";
                    else
                        echo "Order has be set to delivered";
	    
	
	?>
            <form action="homepage.php" method="GET">
                <input type="hidden" name="textbox" value="vendor">
                <input type="hidden" name="textbox2" value="vendor">
                <input type="submit" value="Go Back">
	    </form>
            
	    </center>
    </body>	
</html>