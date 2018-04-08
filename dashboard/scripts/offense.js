states["offense"] = {
	handle : function() {
		// alert("Stats!");
		loadOffensiveStatsView();
		loadPlayerOffensiveStats();
		swReset('beg2');
		swStart('beg2','+');
	}
}
states["gamestats"] = {
	handle : function() {
		// alert("Stats!");
		loadOffensiveStatsView();
		loadPlayerOffensiveStats();
		swReset('beg2');
		swStart('beg2','+');
	}
}

function loadPlayerOffensiveStats() {
	loadHomePlayerOffensiveStats();
	loadAwayPlayerOffensiveStats();
}

function loadOffensiveStatsView() {
	console.log("load offensive status view");
	loadHomeTeamStats();
	loadAwayTeamStats();
	// dojo.hash("stats");
	// dojo.back.addToHistory(states["stats"]);
}

function loadHomeTeamStats() {
	if ( ((viewsStatus.stats.home.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/dashboard/offense.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : homeid
			},
			success : function(data) {
				setOffensiveStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.stats.home.time = new Date().getTime();
	}
}

function loadAwayTeamStats() {
	if ( ((viewsStatus.stats.visitor.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/dashboard/offense.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : awayid
			},
			success : function(data) {
				setOffensiveStats(data, 'away');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.stats.visitor.time = new Date().getTime();
	}
}

function setOffensiveStats(data, team) {
	setData('#stats_' + team + '_firstdowns', data['first_downs']);
	setData('#stats_' + team + '_rushyds', data['rushatt'] + '-' + data['rushyds']);
	setData('#stats_' + team + '_passyds', data['passyds']);
	setData('#stats_' + team + '_passing_stats', data['passcomp'] + '-' + data['passatt'] + '-' + data['passint']);
	setData('#stats_' + team + '_totalyds', data['totalplays'] + '-' + data['totalyds']);
	setData('#stats_' + team + '_avgyds', data['totalplays']!=0?Math.round(data['totalyds']*100/data['totalplays'])/100:0);
	setData('#stats_' + team + '_kick_return', data['kick_rtn_cnt'] + '-' + data['kick_rtn_yds']);
	setData('#stats_' + team + '_punts', data['punt_cnt'] + '-' + data['punt_yds']);
	setData('#stats_' + team + '_penalty', data['penalty_cnt'] + '-' + data['penalty_yds']);
	setData('#stats_' + team + '_possession', data['t_o_p']);
	setData('#stats_' + team + '_third_down', data['third_down_conv'] + '/' + data['third_down_att']);
	setData('#stats_' + team + '_fourth_down', data['fourth_down_conv'] + '/' + data['fourth_down_att']);
	setData('#stats_' + team + '_sacks', data['sacks'] + '-' + data['sackyds']);
	setData('#stats_' + team + '_punt_return', data['punt_rtn_cnt'] + '-' + data['punt_rtn_yds']);
	setData('#stats_' + team + '_int_return', data['int_rtn_cnt'] + '-' + data['int_rtn_yds']);
	setData('#stats_' + team + '_fumbles_returned', data['fumble_rtn_cnt'] + '-' + data['fumble_rtn_yds']);
	setData('#stats_' + team + '_fumbles_lost', data['fumble_cnt'] + '-' + data['fumble_lost_cnt']);
	setData('#stats_' + team + '_red_zone', data['red_zone_conv'] + '/' + data['red_zone_att']);

}


function loadHomePlayerOffensiveStats() {

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
				setPlayerOffensiveStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.homeplayerstats.time = new Date().getTime();
	}

}

function loadAwayPlayerOffensiveStats() {

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
				setPlayerOffensiveStats(data, 'away');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.visitorplayerstats.time = new Date().getTime();
	}

}

function setPlayerOffensiveStats(data, team) {
	setData('#dash_' + team + '_passing',
			genDashPassStats(data['passers'], data['fullteamname']));
	setData('#dash_' + team + '_rushing',
			genDashRushStats(data['rushers'], data['fullteamname']));
	setData('#dash_' + team + '_receiving',
			genDashRecStats(data['receivers'], data['fullteamname']));
}

function genDashPassStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	str = '<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">';
	str += '<tr>';
	str += '<th colspan="6" align="left">' + teamname + ' Passing</th>';
	str += '</tr>';
	str += '<tr>';
	str +=  '<th class="grey" width="50%">&nbsp;</td>';
	str +=  '<th class="grey" width="30%">Cmp-Att-Int</th>';
	str +=  '<th class="grey">Yds</th>';
	str +=  '<th class="grey">TD</th>';
	str +=  '<th class="grey">Long</th>';
	str +=  '<th class="grey">Sack</th>';
	str += '</tr>';
	
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';

	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['cp'] + '-' + val['att'] + '-' + val['int'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['yds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['tds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['long'] + '</td>'
		str += '<td class="dashrow' + bg + centered + '">' + val['sacks'] + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}



function genDashRushStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	str = '<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">';
	str += '<tr>';
	str += '<th colspan="8" align="left">' + teamname + ' Rushing</th>';
	str += '</tr>';
	str += '<tr>';
	str +=  '<th class="grey" width="50%">&nbsp;</td>';
	str +=  '<th class="grey">No.</th>';
	str +=  '<th class="grey">Gain</th>';
	str +=  '<th class="grey">Loss</th>';
	str +=  '<th class="grey">Net</th>';
	str +=  '<th class="grey">TD</th>';
	str +=  '<th class="grey">Lg</th>';
	str +=  '<th class="grey">Avg.</th>';
	str += '</tr>';
	
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';
		//var att = parseInt(val['att']);
		//var tot = parseInt(val['yds']));
		//var test = (att!=0)?Math.round(tot*100/att)/100:0;
	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['att'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['gain'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['loss'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['yds'] + '</td>'
		str += '<td class="dashrow' + bg + centered + '">' + val['tds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['long'] +'</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['avg'] + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function genDashRecStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	str = '<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">';
	str += '<tr>';
	str += '<th colspan="5" align="left">' + teamname + ' Receiving</th>';
	str += '</tr>';
	str += '<tr>';
	str +=  '<th class="grey" width="50%">&nbsp;</td>';
	str +=  '<th class="grey">No.</th>';
	str +=  '<th class="grey">Yds</th>';
	str +=  '<th class="grey">TD</th>';
	str +=  '<th class="grey">Long</th>';
	str += '</tr>';
	
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';

	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['rec'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['yds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['tds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['long'] + '</td>'
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

