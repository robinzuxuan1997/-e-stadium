states["stats"] = {
	handle : function() {
		// alert("Stats!");
		loadStatsView();
	}
}
function loadStatsView() {
	loadHomeStats();
	loadVisitorStats();
	// dojo.hash("stats");
	// dojo.back.addToHistory(states["stats"]);
}

function loadHomeStats() {
	if ((viewsStatus.stats.home.time + 30000) < new Date().getTime()) {
		var xhrArgs = {
			url : server_name + "/service/get/stats/generalStats.php",
			handleAs : "json",
			content : {
				gameid : gameId,
				teamid : homeId
			},
			load : function(data) {
				setHomeStats(data);
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
		viewsStatus.stats.home.time = new Date().getTime();
	}
}

function loadVisitorStats() {
	if ((viewsStatus.stats.visitor.time + 30000) < new Date().getTime()) {
		var xhrArgs = {
			url : server_name + "/service/get/stats/generalStats.php",
			handleAs : "json",
			content : {
				gameid : gameId,
				teamid : visitorId
			},
			load : function(data) {
				setVisitorStats(data);
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
		viewsStatus.stats.visitor.time = new Date().getTime();
	}
}

function loadHomePlayerStats() {

	if ((viewsStatus.homeplayerstats.time + 30000) < new Date().getTime()) {
		var xhrArgs = {
			url : server_name + "/service/get/stats/getPlayerStats.php",
			handleAs : "json",
			content : {
				gameid : gameId,
				teamid : homeId
			},
			load : function(data) {
				setPlayerStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
		viewsStatus.homeplayerstats.time = new Date().getTime();
	}

}

function loadVisitorPlayerStats() {

	if ((viewsStatus.visitorplayerstats.time + 30000) < new Date().getTime()) {
		var xhrArgs = {
			url : server_name + "/service/get/stats/getPlayerStats.php",
			handleAs : "json",
			content : {
				gameid : gameId,
				teamid : visitorId
			},
			load : function(data) {
				setPlayerStats(data, 'visitor');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
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
	dojo.forEach(data, function(i) {
		counter++;

		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += '<td>' + i['name'] + '</td>';
		str += '<td>' + i['cp'] + '</td>';
		str += '<td>' + i['att'] + '</td>';
		str += '<td>' + i['yds'] + '</td>';
		str += '<td>' + i['tds'] + '</td>';
		str += '<td>' + i['int'] + '</td>';
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
	dojo.forEach(data, function(i) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + i['name'] + '</td>';
		str += ' <td>' + i['att'] + '</td>';
		str += ' <td>' + i['yds'] + '</td>';
		str += ' <td>' + i['tds'] + '</td>';
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
	dojo.forEach(data, function(i) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + i['name'] + '</td>';
		str += ' <td>' + i['rec'] + '</td>';
		str += ' <td>' + i['yds'] + '</td>';
		str += ' <td>' + i['tds'] + '</td>';
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
	dojo.forEach(data, function(i) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + i['name'] + '</td>';
		str += ' <td>' + i['punt'] + '</td>';
		str += ' <td>' + i['yds'] + '</td>';
		str += ' <td>' + i['long'] + '</td>';
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
	dojo.forEach(data, function(i) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + i['name'] + '</td>';
		str += ' <td>' + i['ret'] + '</td>';
		str += ' <td>' + i['yds'] + '</td>';
		str += ' <td>' + i['long'] + '</td>';
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
	dojo.forEach(data, function(i) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + i['name'] + '</td>';
		str += ' <td>' + i['ret'] + '</td>';
		str += ' <td>' + i['yds'] + '</td>';
		str += ' <td>' + i['long'] + '</td>';
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
	dojo.forEach(data, function(i) {
		counter++;
		var bg = (counter % 2 == 0) ? '#d2dffc' : '#abbdfa';

		str += '<tr style="background-color :' + bg + '">';
		str += ' <td>' + i['name'] + '</td>';
		str += ' <td>' + i['tkls'] + '</td>';
		str += ' <td>' + i['sks'] + '</td>';
		str += ' <td>' + i['int'] + '</td>';
		str += ' </tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function setData(elementClass, data) {
	dojo.query(elementClass).forEach(function(element) {
		element.innerHTML = data;
	});
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

	setData('.home_yardsperpass', data['passYds'] + '/' + data['passComp']);

	setData('.home_rushingYards', data['rushYds']);

	setData('.home_yardsperrush', data['rushYds'] + '/' + data['rushAtt']);

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

	setData('.visitor_yardsperpass', data['passYds'] + '/' + data['passComp']);

	setData('.visitor_rushingYards', data['rushYds']);

	setData('.visitor_yardsperrush', data['rushYds'] + '/' + data['rushAtt']);

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

}
