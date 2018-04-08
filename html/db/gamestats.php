<table border="0" cellpadding="5" cellspacing="0">
 <tr>
  <td valign="top" width="250">
	<table border="0" cellpadding="2" cellspacing="5" class="dash-stats" width="100%">
	 <tr>
	  <th align="left">Team Stats</th>	
	  <th><?=$awayacrnym;?></th>
	  <th><?=$homeacrnym;?></th>
	 </tr>
	 <tr>
	  <td class="dashrow1">First Downs</td>
	  <td id="stats_away_firstdowns" class="centertd dashrow1"></td>
	  <td id="stats_home_firstdowns" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Rushes-Yards</td>
	  <td id="stats_away_rushyds" class="centertd dashrow2"></td>
	  <td id="stats_home_rushyds" class="centertd dashrow2"></td>
	 </tr>
	 <tr>
	  <td class="dashrow1">Pass Yards</td>
	  <td id="stats_away_passyds" class="centertd dashrow1"></td>
	  <td id="stats_home_passyds" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Passing</td>
	  <td id="stats_away_passing_stats" class="centertd dashrow2"></td>
	  <td id="stats_home_passing_stats" class="centertd dashrow2"></td>
	 </tr>
	 <tr>
	  <td class="dashrow1">Plays-Total Yds</td>
	  <td id="stats_away_totalyds" class="centertd dashrow1"></td>
	  <td id="stats_home_totalyds" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Average Yds/Play</td>
	  <td id="stats_away_avgyds" class="centertd dashrow2"></td>
	  <td id="stats_home_avgyds" class="centertd dashrow2"></td>
	 </tr>
	 <tr>
	  <td class="dashrow1">Kick Return</td>
	  <td id="stats_away_kick_return" class="centertd dashrow1"></td>
	  <td id="stats_home_kick_return" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Punt Return</td>
	  <td id="stats_away_punt_return" class="centertd dashrow2"></td>
	  <td id="stats_home_punt_return" class="centertd dashrow2"></td>
	 </tr>
	 <tr>
	  <td class="dashrow1">Int Return</td>
	  <td id="stats_away_int_return" class="centertd dashrow1"></td>
	  <td id="stats_home_int_return" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Fumble Return</td>
	  <td id="stats_away_fumbles_returned" class="centertd dashrow2"></td>
	  <td id="stats_home_fumbles_returned" class="centertd dashrow2"></td>
	 </tr>
	 <tr>
	  <td class="dashrow1">Fumbles Lost</td>
	  <td id="stats_away_fumbles_lost" class="centertd dashrow1"></td>
	  <td id="stats_home_fumbles_lost" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Penalties</td>
	  <td id="stats_away_penalty" class="centertd dashrow2"></td>
	  <td id="stats_home_penalty" class="centertd dashrow2"></td>
	 </tr>
	 <tr>
	  <td class="dashrow1">Punts</td>
	  <td id="stats_away_punts" class="centertd dashrow1"></td>
	  <td id="stats_home_punts" class="centertd dashrow1"></td>
	 </tr>
	  <tr>
	  <td class="dashrow2">Possession Time</td>
	  <td id="stats_away_possession" class="centertd dashrow2"></td>
	  <td id="stats_home_possession" class="centertd dashrow2"></td>
	 </tr>
	  <tr>
	  <td class="dashrow1">Third Down Effic.</td>
	  <td id="stats_away_third_down" class="centertd dashrow1"></td>
	  <td id="stats_home_third_down" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Fourth Down Effic.</td>
	  <td id="stats_away_fourth_down" class="centertd dashrow2"></td>
	  <td id="stats_home_fourth_down" class="centertd dashrow2"></td>
	 </tr>
	 <tr>
	  <td class="dashrow1">Red Zone Effic.</td>
	  <td id="stats_away_red_zone" class="centertd dashrow1"></td>
	  <td id="stats_home_red_zone" class="centertd dashrow1"></td>
	 </tr>
	 <tr>
	  <td class="dashrow2">Sacks By</td>
	  <td id="stats_away_sacks" class="centertd dashrow2"></td>
	  <td id="stats_home_sacks" class="centertd dashrow2"></td>
	 </tr>


	</table>
  </td>
  <td valign="top" width="350"> 
  <div id="dash_away_passing"></div>
	<div id="dash_away_rushing"></div>
	<div id="dash_away_receiving"></div>
	<!--<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">
	 <tr>
	  <th colspan="8" align="left"><?=$away->getName();?> Rushing</th>
	 </tr>
	 <tr>
	  <th class="grey" width="50%">&nbsp;</td>
	  <th class="grey">No.</th>
	  <th class="grey">Gain</th>
	  <th class="grey">Loss</th>
	  <th class="grey">Net</th>
	  <th class="grey">TD</th>
	  <th class="grey">Lg</th>
	  <th class="grey">Avg.</th>
	 </tr>
	</table>
	<br />
	<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">
	 <tr>
	  <th colspan="6" align="left"><?=$away->getName();?> Receiving</th>
	 </tr>
	 <tr>
	  <th class="grey" width="50%">&nbsp;</td>
	  <th class="grey">No.</th>
	  <th class="grey">Yds</th>
	  <th class="grey">TD</th>
	  <th class="grey">Long</th>
	 </tr>
	</table>-->
  </td>
  <td valign="top" width="350">
	<!--<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">
	 <tr>
	  <th colspan="6" align="left"><?=$home->getName();?> Passing</th>
	 </tr>
	 <tr>
	  <th class="grey" width="50%">&nbsp;</td>
	  <th class="grey" width="30%">Cmp-Att-Int</th>
	  <th class="grey">Yds</th>
	  <th class="grey">TD</th>
	  <th class="grey">Long</th>
	  <th class="grey">Sack</th>
	 </tr>
	</table>
	<br />-->
	<div id="dash_home_passing"></div>
	<div id="dash_home_rushing"></div>
	<div id="dash_home_receiving"></div>
	<!--<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">
	 <tr>
	  <th colspan="8" align="left"><?=$home->getName();?> Rushing</th>
	 </tr>
	 <tr>
	  <th class="grey" width="50%">&nbsp;</td>
	  <th class="grey">No.</th>
	  <th class="grey">Gain</th>
	  <th class="grey">Loss</th>
	  <th class="grey">Net</th>
	  <th class="grey">TD</th>
	  <th class="grey">Lg</th>
	  <th class="grey">Avg.</th>
	 </tr>
	</table>
	<br />
	<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">
	 <tr>
	  <th colspan="6" align="left"><?=$home->getName();?> Receiving</th>
	 </tr>
	 <tr>
	  <th class="grey" width="50%">&nbsp;</td>
	  <th class="grey">No.</th>
	  <th class="grey">Yds</th>
	  <th class="grey">TD</th>
	  <th class="grey">Long</th>
	 </tr>
	</table>-->
  </td>
 </tr>
</table>
<br /><br /><br /><br /><br />	
