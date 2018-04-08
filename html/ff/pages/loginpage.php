
<?
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
		<a id="btnLogin" data-role="button" class="ui-btn-a">Login</a>
		<a id="btnCreateAccount" data-role="button" class="ui-btn-a">Create Account</a>
	</center>
</div><!-- /content -->



