<div class="accordion">
	<div class="head">Team Stats</div>
	<div class="team-stats">
		<table class="stats_table">
			<tr>
				<th width="60%"></th>
				<th width="20%" class="score_board_visitor_acronym"><?=$away->getAcronym();?></th>
				<th width="20%" class="score_board_home_acronym"><?=$home->getAcronym();?></th>
			</tr>
			<tr>
				<th>First Downs</th>
				<th class="visitor_firstDowns"></th>
				<th class="home_firstDowns"></th>
			</tr>
			<tr>
				<td>3rd Down Efficiency</td>
				<td class="visitor_thirdEfficiency"></td>
				<td class="home_thirdEfficiency"></td>
			</tr>
			<tr>
				<td>4th Down Efficiency</td>
				<td class="visitor_fourthEfficiency"></td>
				<td class="home_fourthEfficiency"></td>
			</tr>
			<tr>
				<th>Total Yards</th>
				<th class="visitor_totalYards"></th>
				<th class="home_totalYards"></th>
			</tr>
			<tr>
				<th>Passing Yards</th>
				<td class="visitor_passingYards"></td>
				<td class="home_passingYards"></td>
			</tr>
			<tr>
				<td>Comp-Att</td>
				<td class="visitor_CompAtt"></td>
				<td class="home_CompAtt"></td>
			</tr>
			<tr>
				<td>Yards Per Pass</td>
				<td class="visitor_yardsperpass"></td>
				<td class="home_yardsperpass"></td>
			</tr>
			        <td>Yards Per Attempt</td>
                                <td class="visitor_yardsperatt"></td>
                                <td class="home_yardsperatt"></td>
			<tr>
			</tr>
			<tr>
				<th>Rushing Yards</th>
				<td class="visitor_rushingYards"></td>
				<td class="home_rushingYards"></td>
			</tr>
			<tr>
                                <td>Rushing Attempts</td>
                                <td class="visitor_rushingAtt"></td>
                                <td class="home_rushingAtt"></td>
                        </tr>
			<tr>
				<td>Yards Per Rush</td>
				<td class="visitor_yardsperrush"></td>
				<td class="home_yardsperrush"></td>
			</tr>
			<tr>
				<th>Penalties-Yards</th>
				<td class="visitor_penaltiesYards"></td>
				<td class="home_penaltiesYards"></td>
			</tr>
			<tr>
				<th>Turnovers</th>
				<th  class="visitor_turnovers"></th>
				<th class="home_turnovers"></th>
			</tr>
			<tr>
				<td>Fumbles</td>
				<td class="visitor_fumbles"></td>
				<td class="home_fumbles"></td>
			</tr>
			<tr>
				<td>Interceptions</td>
				<td class="visitor_interceptions"></td>
				<td class="home_interceptions"></td>
			</tr>
			<tr>
				<th>Time of Possession</th>
				<td class="visitor_timepossession"></td>
				<td class="home_timepossession"></td>
			</tr>
			<tr>
				<th colspan=3>Defense</th>
			</tr>
			<tr>
				<th>Tackles</th>
				<th class="visitor_tackles"></th>
				<th class="home_tackles"></th>
			</tr>
			<tr>
				<td>Sacks/Yards</td>
				<td class="visitor_sackYards"></td>
				<td class="home_sackYards"></td>
			</tr>
			<tr>
				<td>Tackles For Loss/Yards</td>
				<td class="visitor_tacklesforyardslost"></td>
				<td class="home_tacklesforyardslost"></td>
			</tr>
			<tr>
				<th>Fumbles Forced</th>
				<th class="visitor_fumblesForced"></th>
				<th class="home_fumblesForced"></th>
			</tr>
			<tr>
				<td>Recovered/Yards</td>
				<td class="visitor_recoveredYards"></td>
				<td class="home_recoveredYards"></td>
			</tr>
			<tr>
				<th>Interceptions</th>
				<th class="visitor_inter"></th>
				<th class="home_inter"></th>
			</tr>
			<tr>
				<td>Return Yards</td>
				<td class="visitor_returnYards"></td>
				<td class="home_returnYards"></td>
			</tr>
                        <tr>
                                <th>Kickoff Return Yards</th>
                                <th class="visitor_kickReturnYds"></th>
                                <th class="home_kickReturnYds"></th>
                        </tr>
                        <tr>
                                <td>Kickoff Returns</td>
                                <td class="visitor_kickReturnCnt"></td>
                                <td class="home_kickReturnCnt"></td>
                        </tr>
			<tr>
                                <td>Yards Per Return</td>
                                <td class="visitor_kickReturnAvg"></td>
                                <td class="home_kickReturnAvg"></td>
                        </tr>
			<tr>
                                <td>Long</td>
                                <td class="visitor_kickReturnLong"></td>
                                <td class="home_kickReturnLong"></td>
                        </tr>
	                <tr>
                                <th>Punts</th>
                                <th class="visitor_puntCount"></th>
                                <th class="home_puntCount"></th>
                        </tr>
                        <tr>
                                <td>Long</td>
                                <td class="visitor_puntLong"></td>
                                <td class="home_puntLong"></td>
                        </tr>


		</table>
	</div>
	<div class="head"><?=$home->getName();?> Stats</div>
	<div>
		<?php include 'pages/homestats.php'; ?>
	</div>
	<div class="head"><?=$away->getName();?> Stats</div>
	<div>
		<?php include 'pages/awaystats.php'; ?>
	</div>
</div>
