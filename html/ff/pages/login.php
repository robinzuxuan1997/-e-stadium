<!DOCTYPE html> 
<html>
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>FriendFinder</title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
        <script src="../js/login.js"></script>
        <script src="../js/createaccount.js"></script>
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
		<!-- main login page -->
		<div data-role="page" id="login">
			<?php
				include_once('./components/login-header.php');
			?>
			<div data-role="content" >	
				<center>
					<h2>Login:</h2>
				</center>
				</br>
				<label for="usrName">Username:</label>
				<input type="text" id="usrName" value="" data-clear-btn="true"/>
				<label for="pwd">Password:</label>
				<input type="password" id="pwd" value="" data-clear-btn="true"/>
				</br>
				<center>
					<a id="btnLogin" data-role="button">Login</a>
					<a id="btnCreateAccount" data-role="button">Create Account</a>
				</center>
			</div><!-- /content -->
		</div><!-- /page -->
		<!-- create account page -->
		<!-- CREATE ACCOUNT PAGE -->
		<div data-role="page" id="createaccount">
			<?
				include_once('createaccountpage.php');
			?>
		</div> <!-- /createaccount -->
	</body>
</html>


