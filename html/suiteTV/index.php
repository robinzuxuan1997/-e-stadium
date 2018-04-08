<html>	
    <head>
        <link rel="stylesheet" href="style.css"/>
	<script type="text/javascript" src="clicktable.js"></script>
        <title>SuiteTV Food Orders</title>
    </head>
    <body>
	    <script type="text/javascript"> 
		$(document).ready(function()
		{
		    $('#main tr').click(function()
		    {
			var url = "/order.php";    
			$(location).attr('href',url);
			
		    });

		});
	    </script>
	    <center>
	    <h1> SuiteTV Food Orders</h1>
	
	    <?php
		//Connect to the MySQL server
		    if(!($connection = @ mysql_connect("eugene.vip.gatech.edu",test,"1234")))
			echo "connect failed<br>";
		    
		    // Select database
		    if(!(mysql_select_db("test",$connection)))
			echo "db select failed<br>\n";
	    
		    $query = "SELECT * FROM `orders`";
	    
		    //Query the database
	    
		    if(!($result = @ mysql_query($query,$connection)))
			echo "query failed<br>";
	    
		
		    echo '<table id="main">';
		    echo '<tr><th>OrderID</th><th>Delivered?</th><th>Suite</th><th>Order Date<th>Total</th></tr>';	
		    while($row = mysql_fetch_array($result))
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
			    <form action="order.php" method="get">
			    <input type="hidden" name="name" value="<?php echo $row["id"] ?>"> 
			    <input type="submit" value="View">
			    </form>
			</td> 
			<?php
			echo '</tr>';
		    }
		    echo '</table>';
	?>
			<br>
			If you are vendors/or VIP admins
			<form action="login.html" method="GET">
			<input type="submit" value="Go">
			</form>
	    </center>
    </body>	
</html>