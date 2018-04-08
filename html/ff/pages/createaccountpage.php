
<?
	include_once('./components/createaccount-header.php');
?>
<div data-role="content" >	
	<center>
		<h3>Create Account:</h3>
	</center>
	<form>
    	<ul data-role="listview" data-inset="true">
        <li class="ui-field-contain">
        	<label for="fname">First Name:</label>
            <input type="text" name="fname" id="fname" data-clear-btn="true">
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" id="lname" data-clear-btn="true">
            <label for="age">Age:</label>
            <input type="number" name="age" id="age" data-clear-btn="false">
        </li>
        <li class="ui-field-contain">
        	<label for="username">Username:</label>
        	<input type="text" name="username" id="username" data-clear-btn="true">
        	<label for="password">Password:</label>
        	<input type="password" name="password" id="password" data-clear-btn="true">
        </li>
        <li class="ui-body ui-body-b">
            <fieldset class="ui-grid-solo">
                <div class="ui-block-a"><button type="button" class="ui-btn ui-corner-all ui-btn-a" id="submit">Submit</button></div>
            </fieldset>
        </li>
    </ul>
	</form>
</div><!-- /content -->