<!DOCTYPE html> 
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>FriendFinder</title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
       <!-- <script src="../js/main.js"></script>
	<script src="../js/map.js"></script> -->
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCuox9Kc5opHDAjapGHAlp7j1-fzP0eAFs&sensor=true"></script>
        <!-- may want to host ourselves instead of CDN 
        <script src="../js/main.js"></script>
        <script src="../js/jquery/jquery-2.0.3.min.js"></script>
        <script src="../js/jquery/jquery.mobile-1.3.2.min.js"></script>
        <link rel="stylesheet" href="../css/jquery.mobile-1.3.2.min.css" />
        -->
</head>

<body> 
<!-- LOGIN PAGE -->
<div data-role="page" id="login">
	<?
		include_once('./loginpage.php');
	?>
</div><!-- /login page -->

<!-- MAIN PAGE -->
<div data-role="page" id ="main">
	<?
		include_once('main.php');
	?>
</div><!-- /main page -->

<!-- CREATE ACCOUNT PAGE -->
<div data-role="page" id="createaccount">
	<?
		include_once('createaccountpage.php');
	?>
</div> <!-- /createaccount -->

</body>
<script>
        $(document).ready( function() {
                // LOGIN BUTTON CLICKED
                $("#btnLogin").click( function() {
                        // check login
                        checkLogin($("#usrName").val(), $("#pwd").val());       
                });

                // CREATE ACCOUNT BUTTON CLICKED
                $("#btnCreateAccount").click( function() {
                        // navigate to create account page
                        $.mobile.changePage("#createaccount", "slide", true, true);
                });
        });
</script>
</html>
