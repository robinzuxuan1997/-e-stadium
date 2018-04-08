states["stats"] = {
	handle : function() {
		// alert("Stats!");
		loadStatsView();
	}
}
function loadStatsView() {
	console.log("load status view");
	loadHomeStats();
	loadVisitorStats();
	loadHomePlayerStats();
	loadVisitorPlayerStats();
	// dojo.hash("stats");
	// dojo.back.addToHistory(states["stats"]);
}

function loadHomeStats() {
	if ((viewsStatus.stats.home.time + 30000) < new Date().getTime()) {
		$.ajax({
			url : server_name + "/service/get/stats/generalStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : homeid
			},
			success : function(data) {
				setHomeStats(data);
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.stats.home.time = new Date().getTime();
	}
}

function loadVisitorStats() {
	if ((viewsStatus.stats.visitor.time + 30000) < new Date().getTime()) {
		$.ajax({
			url : server_name + "/service/get/stats/generalStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : awayid
			},
			success : function(data) {
				setVisitorStats(data);
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.stats.visitor.time = new Date().getTime();
	}
}

function loadHomePlayerStats() {

	if ((viewsStatus.homeplayerstats.time + 30000) < new Date().getTime()) {
		$.ajax({
			url : server_name + "/service/get/stats/getPlayerStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : homeid
			},
			success : function(data) {
				setPlayerStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.homeplayerstats.time = new Date().getTime();
	}

}

function loadVisitorPlayerStats() {

	if ((viewsStatus.visitorplayerstats.time + 30000) < new Date().getTime()) {
		$.ajax({
			url : server_name + "/service/get/stats/getPlayerStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : awayid
			},
			success : function(data) {
				setPlayerStats(data, 'visitor');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});

		viewsStatus.visitorplayerstats.time = new Date().getTime();
	}

}

function setPlayerStats(data, team) {
	setData('#stats_' + team + '_passing',
			generatePassingStats(data['passers']));
	setData('#stats_' + team + '_rushing',
			generateRushingStats(data['rushers']));
	setData('#stats_' + team + '_receiving',
			generateReceivingStats(data['receivers']));
	setData('#stats_' + team + '_punting',
			generatePuntingStats(data['punters']));
	setData('#stats_' + team + '_kick_return',
			generateKickReturnsStats(data['kickreturners']));
	setData('#stats_' + team + '_punt_returns',
			generatePuntReturnsStats(data['puntreturners']));
	setData('#stats_' + team + '_defense',
			generateDefenseStats(data['defense']));
}

function generatePassingStats(data) {
	var str = '<table width="100%" >';
	str += '<tr><td></td><td>CP</td><td>ATT</td><td>YDS</td><td>TD</td><td>INT</td></tr>';
	var counter = 0;
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += '<td>' + val['name'] + '</td>';
		str += '<td>' + val['cp'] + '</td>';
		str += '<td>' + val['att'] + '</td>';
		str += '<td>' + val['yds'] + '</td>';
		str += '<td>' + val['tds'] + '</td>';
		str += '<td>' + val['int'] + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function generateRushingStats(data) {
	var str = '<table width="100%" >';
	str += '<tr><td></td><td>ATT</td><td>YDS</td><td>TD</td></tr>';
	var counter = 0;
	$.each(data, function(idx,val) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + val['name'] + '</td>';
		str += ' <td>' + val['att'] + '</td>';
		str += ' <td>' + val['yds'] + '</td>';
		str += ' <td>' + val['tds'] + '</td>';
		str += ' </tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function generateReceivingStats(data) {
	var str = '<table width="100%" >';
	str += '<tr><td></td><td>REC</td><td>YDS</td><td>TD</td></tr>';
	var counter = 0;
	$.each(data, function(idx, val) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + val['name'] + '</td>';
		str += ' <td>' + val['rec'] + '</td>';
		str += ' <td>' + val['yds'] + '</td>';
		str += ' <td>' + val['tds'] + '</td>';
		str += ' </tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function generatePuntingStats(data) {
	var str = '<table width="100%" >';
	str += '<tr><td></td><td>PUNT</td><td>YDS</td><td>LONG</td></tr>';
	var counter = 0;
	$.each(data, function(idx, val) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + val['name'] + '</td>';
		str += ' <td>' + val['punt'] + '</td>';
		str += ' <td>' + val['yds'] + '</td>';
		str += ' <td>' + val['long'] + '</td>';
		str += ' </tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function generateKickReturnsStats(data) {
	var str = '<table width="100%" >';
	str += '<tr><td></td><td>RET</td><td>YDS</td><td>LONG</td></tr>';
	var counter = 0;
	$.each(data, function(idx,val) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + val['name'] + '</td>';
		str += ' <td>' + val['ret'] + '</td>';
		str += ' <td>' + val['yds'] + '</td>';
		str += ' <td>' + val['long'] + '</td>';
		str += ' </tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function generatePuntReturnsStats(data) {
	var str = '<table width="100%" >';
	str += '<tr><td></td><td>RET</td><td>YDS</td><td>LONG</td></tr>';
	var counter = 0;
	$.each(data, function(idx, val) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + val['name'] + '</td>';
		str += ' <td>' + val['ret'] + '</td>';
		str += ' <td>' + val['yds'] + '</td>';
		str += ' <td>' + val['long'] + '</td>';
		str += ' </tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function generateDefenseStats(data) {
	var str = '<table width="100%">';
	str += '<tr><td></td><td>TKLS</td><td>SACK</td><td>INT</td></tr>';
	var counter = 0;
	$.each(data, function(idx, val) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + val['name'] + '</td>';
		str += ' <td>' + val['tkls'] + '</td>';
		str += ' <td>' + val['sks'] + '</td>';
		str += ' <td>' + val['int'] + '</td>';
		str += ' </tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function setHomeStats(data) {

	setData('.home_quarter_1', data['scoreQ1']);

	setData('.home_quarter_2', data['scoreQ2']);

	setData('.home_quarter_3', data['scoreQ3']);

	setData('.home_quarter_4', data['scoreQ4']);

	setData('.score_board_home_total', data['scoreF']);

	setData('.home_firstDowns', data['firstDowns']);

	setData('.home_thirdEfficiency', data['thirdConvs'] + '-'
			+ data['thirdAttempts']);

	setData('.home_fourthEfficiency', data['fourthConvs'] + '-'
			+ data['fourthAttempts']);

	setData('.home_totalYards', data['passYds'] + data['rushYds']);

	setData('.home_passingYards', data['passYds']);

	setData('.home_CompAtt', data['passComp'] + '-' + data['passAtt']);

	setData('.home_yardsperpass', data['passComp']!=0?Math.round(data['passYds']*100 / data['passComp'])/100:0);

	setData('.home_yardsperatt', data['passAtt']!=0?Math.round(data['passYds']*100 / data['passAtt'])/100:0);

	setData('.home_rushingYards', data['rushYds']);

	setData('.home_rushingAtt', data['rushAtt']);

	setData('.home_yardsperrush', data['rushAtt']!=0?Math.round(data['rushYds']*100 / data['rushAtt'])/100:0);

	setData('.home_penaltiesYards', data['penaltyYds']);

	setData('.home_turnovers', data['turnovers']['interceptions']
			+ data['turnovers']['fumbles']);

	setData('.home_fumbles', data['turnovers']['fumbles']);

	setData('.home_interceptions', data['turnovers']['interceptions']);

	setData('.home_timepossession', data['timeOfPos']);

	setData('.home_tackles', data['tackles']['number']);

	setData('.home_sackYards', data['tackles']['sacks'] + '/' + data['sackyds']);

	setData('.home_tacklesforyardslost', data['tackles']['tfl'] + '/'
			+ data['tackles']['tflyds']);

	setData('.home_fumblesForced', data['fumbles']['forced']);

	setData('.home_recoveredYards', data['fumbles']['recovered'] + '/'
			+ data['fumbles']['getFryds']);

	setData('.home_inter', data['inter']['num']);

	setData('.home_returnYards', data['inter']['yds']);

        setData('.home_kickReturnCnt', data['kickReturnCnt']);

        setData('.home_kickReturnYds', data['kickReturnYds']);
        
        setData('.home_kickReturnLong', data['kickReturnLong']);

	setData('.home_kickReturnAvg', data['kickReturnCnt']!=0?Math.round(data['kickReturnYds']*100 / data['kickReturnCnt'])/100:0);

        setData('.home_puntCount', data['puntCount']);

        setData('.home_puntLong', data['puntLong']);
}

function setVisitorStats(data) {
	setData('.visitor_quarter_1', data['scoreQ1']);

	setData('.visitor_quarter_2', data['scoreQ2']);

	setData('.visitor_quarter_3', data['scoreQ3']);

	setData('.visitor_quarter_4', data['scoreQ4']);

	setData('.score_board_visitor_total', data['scoreF']);

	setData('.visitor_firstDowns', data['firstDowns']);

	setData('.visitor_thirdEfficiency', data['thirdConvs'] + '-'
			+ data['thirdAttempts']);

	setData('.visitor_fourthEfficiency', data['fourthConvs'] + '-'
			+ data['fourthAttempts']);

	setData('.visitor_totalYards', data['passYds'] + data['rushYds']);

	setData('.visitor_passingYards', data['passYds']);

	setData('.visitor_CompAtt', data['passComp'] + '-' + data['passAtt']);

	setData('.visitor_yardsperpass', data['passComp']!=0?Math.round(data['passYds']*100 / data['passComp'])/100:0);

	setData('.visitor_yardsperatt', data['passAtt']!=0?Math.round(data['passYds']*100 / data['passAtt'])/100:0);

	setData('.visitor_rushingYards', data['rushYds']);

	setData('.visitor_rushingAtt', data['rushAtt']);

	setData('.visitor_yardsperrush', data['rushAtt']!=0?Math.round(data['rushYds']*100 / data['rushAtt'])/100:0);

	setData('.visitor_penaltiesYards', data['penaltyYds']);

	setData('.visitor_turnovers', data['turnovers']['interceptions']
			+ data['turnovers']['fumbles']);

	setData('.visitor_fumbles', data['turnovers']['fumbles']);

	setData('.visitor_interceptions', data['turnovers']['interceptions']);

	setData('.visitor_timepossession', data['timeOfPos']);

	setData('.visitor_tackles', data['tackles']['number']);

	setData('.visitor_sackYards', data['tackles']['sacks'] + '/'
			+ data['sackyds']);

	setData('.visitor_tacklesforyardslost', data['tackles']['tfl'] + '/'
			+ data['tackles']['tflyds']);

	setData('.visitor_fumblesForced', data['fumbles']['forced']);

	setData('.visitor_recoveredYards', data['fumbles']['recovered'] + '/'
			+ data['fumbles']['getFryds']);

	setData('.visitor_inter', data['inter']['num']);

	setData('.visitor_returnYards', data['inter']['yds']);

	setData('.visitor_kickReturnCnt', data['kickReturnCnt']);

	setData('.visitor_kickReturnYds', data['kickReturnYds']);
	
	setData('.visitor_kickReturnLong', data['kickReturnLong']);

	setData('.visitor_kickReturnAvg', data['kickReturnCnt']!=0?Math.round(data['kickReturnYds']*100 / data['kickReturnCnt'])/100:0);

	setData('.visitor_puntCount', data['puntCount']);

	setData('.visitor_puntLong', data['puntLong']);
}

function setData(descriptor, value){
	$(descriptor).html(value);
}
