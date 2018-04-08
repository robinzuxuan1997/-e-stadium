states["defense"] = {
	handle : function() {
		// alert("Stats!");
		loadDefenseStatsView();
		swReset('beg2');
		swStart('beg2','+');
	}
}

function loadDefenseStatsView() {
	loadHomePlayerDefensiveStats();
	loadAwayPlayerDefensiveStats();

}

states["scoring"] = {
	handle : function() {
		getGameSummary();
	}
}

function loadHomePlayerDefensiveStats() {

	if ( ((viewsStatus.dbhomedefensestats.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/stats/getPlayerStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : homeid
			},
			success : function(data) {
				setPlayerDefensiveStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.dbhomedefensestats.time = new Date().getTime();
	}

}

function loadAwayPlayerDefensiveStats() {

	if ( ((viewsStatus.dbawaydefensestats.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/stats/getPlayerStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : awayid
			},
			success : function(data) {
				setPlayerDefensiveStats(data, 'away');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.dbawaydefensestats.time = new Date().getTime();
	}

}

function setPlayerDefensiveStats(data, team) {
	setData('#dash_' + team + '_defense',
			genDashDefenseStats(data['defense'], data['fullteamname']));
	console.log("data set!");
}




function genDashDefenseStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	str =	'<table border="0" cellpadding="2" cellspacing="5" width="100%" class="dash-stats">';
	str+=		'<tr>';
	str+=		'<th colspan="12">' + teamname + ' Defense </th>';
	str+=		 '</tr>';
	str+=		 '<tr>';
	str+=		'<th class="grey" width="20%"></th>';
	str+=		'<th class="grey">Solo</th>';
	str+=		'<th class="grey">Ast</th>';
	str+=		'<th class="grey">Total</th>';
	str+=		'<th class="grey">TFL/Yds</th>';
	str+=		'<th class="grey">Sack/Yds</th>';
	str+=		'<th class="grey">FF</th>';
	str+=		'<th class="grey">FR-Yds</th>';
	str+=		'<th class="grey">Int-Yds</th>';
	str+=		'<th class="grey">BrUp</th>';
	str+=		'<th class="grey">Blkd</th>';
	str+=		'<th class="grey">QBH</th>';
	str+=		 '</tr>';
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';

	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['tkua'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['tka'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['tkls'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['tfl'] + '/' + val['tflyds'] + '</td>'
		str += '<td class="dashrow' + bg + centered + '">' + val['sks'] + '/' + val['skyds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['int'] + '/' + val['intyds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;

}

