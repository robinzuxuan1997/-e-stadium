<script>
function goBut()
{
	//$.mobile.changePage($("#button"), "slide", true, true);
	$.mobile.changePage("#button");
}
</script>
<div id="drivetracker-edgelist">
	<div id="drivetracker-driveheading">
		<div id="drivetracker-drivename"></div>
		<div class="drivetracker-filler"></div>
		<!--<div class="drivetracker-refresh" data-role="button"
			id="drivetracker-update" onclick="drivetracker.updateR(event)">Update</div>-->
		<div class="homebutton" data-role="button" onclick="goBut()">Show QTs</div>
                <!--<div class="homebutton" data-role="button" onclick="location.href='#button'">Show QTs</div>-->
		
                <div id="drivetracker-heading-filler">&nbsp;</div>
	</div>
	<!-- drive tracker div needs to be centered
	<center>
	<div id="field-container">
	    <canvas id="field_canvas">
	    	    
	    </canvas>
	    <img id="drvtrkr_img" />

	</div>
	
	</center>
	<php
	  if ($scroll=="no"){
   	     include("drivedetails.php");
	  }
	?>
	<div id="drivetracker-drivelist">
		Drives:<br />  -->
		<!--<select id="drivetracker-drives" data-native-menu="true"
			onchange="drivetracker.driveChanged(event)">
			<option>Drives</option>
		</select>
		-->
		
		<!--<center><div id="drivetracker-legend">
			<table>
				<tr>
					<td align="left"><img
						src="<?=$path->getPath("image_drivetracker_legend_rush")?>">&nbsp;Rush<br />
					<img src="<?=$path->getPath("image_drivetracker_legend_pass")?>">&nbsp;Pass<br />
					<img
						src="<?=$path->getPath("image_drivetracker_legend_incomplete")?>">&nbsp;Incomplete
					Pass<br />
					</td>
					<td align="left"><img
						src="<?=$path->getPath("image_drivetracker_legend_penalty")?>">&nbsp;Penalty<br />
					<img src="<?=$path->getPath("image_drivetracker_legend_kickoff")?>">&nbsp;Punt
					or Kickoff<br />
					<img src="<?=$path->getPath("image_drivetracker_legend_fumble")?>">&nbsp;Fumble
					or Interception<br />
					</td>
				</tr>
			</table>
		</div></center>-->
		<table id="drivetracker-drivesQT1" cellpadding="0" border="0">
		  
		</table>
		<!--<form action="button.php" method="GET">
                    <INPUT TYPE = "Submit" Name = "Test" VALUE = "show all quarters">
                </form>-->
		
	</div>
</div>