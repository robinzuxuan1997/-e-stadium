<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
        <title>Welcome</title>
        <link rel="shortcut icon" href="corkboardLogo.ico">
    </head>
    <body>
    	<!--
        <form action="pushpinSearch.php" method="GET">
        -->
            <?php
            foreach($_GET as $x => $value)
            {
                if ($x == "textbox")
                {
                    $login = $value;
                }
                elseif ($x =="textbox2")
                {
                    $pass = $value;
                }
            }
            
            if ($login == "vendor" && $pass == "vendor")
            {
                  if(!($connection = @ mysql_connect("eugene.vip.gatech.edu",test,"1234")))
			echo "connect failed<br>";
		    
		    // Select database
		    if(!(mysql_select_db("test",$connection)))
			echo "db select failed<br>\n";
	    
		    $query = "SELECT * FROM `orders` WHERE delivered = 'No'";
	    
		    //Query the database
		    $result = @ mysql_query($query,$connection);
		    $result2 = @ mysql_query($query,$connection);
		    if (mysql_fetch_array($result) == null)
		    {
			echo '<center>';
			echo "Every order has been delivered! Good Job";
			echo '<form action="index.php" method="GET">';
			echo '<input type="submit" value="Go Back">';
			echo '</form>';
			echo '</center>';
			
		    }
		    else
		    {
			if(!($result2 = @ mysql_query($query,$connection)))
			echo "query failed<br>";
		    
			echo '<center>';	
			echo '<table id="main">';
			echo '<tr><th>OrderID</th><th>Delivered?</th><th>Suite</th><th>Order Date<th>Total</th></tr>';	
			while($row = mysql_fetch_array($result2))
			{
			    $send = $row["id"];
			
			    echo '<tr>';
			    echo '<td>',$row["id"],'</td>';
			    echo '<td>',$row["delivered"],'</td>';
			    echo '<td>',$row["suite"],'</td>';
			    echo '<td>',$row["orderedDate"],'</td>';
			    echo '<td>',$row["total"],'</td>';
			?>
			    <td>
			        <form action="delivered.php" method="get">
			        <input type="hidden" name="name" value="<?php echo $row["id"] ?>"> 
			        <input type="submit" value="Click if you delivered">
			        </form>
			    </td> 
		        <?php
			    echo '</tr>';
			
		        }
		        echo '</table>';
			echo '<form action="index.php" method="GET">';
			echo '<input type="submit" value="Go Back">';
			echo '</form>';
		        echo '</center>';
		    }
            }
            else
            {
		echo "<center>";
                echo "Wrong username/password<br>";
                echo "Go back and try again or contact VIP team";
		echo '<form action="index.php" method="GET">';
		echo '<input type="submit" value="Go Back">';
		echo '</form>';
                echo "</center>";
            }
           ?>
    </body>
</html>