states["specialteams"] = {
	handle : function() {
		// alert("Stats!");
		console.log("Loading Special Teams");
		loadSpecialTeamsStatsView();
		swReset('beg2');
		swStart('beg2','+');
	}
}

function loadSpecialTeamsStatsView() {
	loadHomePlayerPuntingStats();
	loadAwayPlayerPuntingStats();
}

function loadHomePlayerPuntingStats() {

	if ( ((viewsStatus.dbhomeststats.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/stats/getPlayerStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : homeid
			},
			success : function(data) {
				setPlayerPuntingStats(data, 'home');
				setPlayerReturnStats(data, 'home');
				setPlayerFGAStats(data, 'home');
				setPlayerKickoffStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		if (force_refresh) console.log("force refresh!");
		viewsStatus.dbhomeststats.time = new Date().getTime();
	}

}

function loadAwayPlayerPuntingStats() {

	if ( ((viewsStatus.dbawayststats.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/stats/getPlayerStats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : awayid
			},
			success : function(data) {
				setPlayerPuntingStats(data, 'away');
				setPlayerReturnStats(data, 'away');
				setPlayerFGAStats(data, 'away');
				setPlayerKickoffStats(data, 'away');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		if (force_refresh) console.log("force refresh!");
		viewsStatus.dbawayststats.time = new Date().getTime();
	}

}

/*
function loadHomeFGAStats() {

	//if ( ((viewsStatus.dbhomeststats.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/stats/getFGAs.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : homeid
			},
			success : function(data) {
				setPlayerFGAStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		if (force_refresh) console.log("force refresh!");
		viewsStatus.dbhomeststats.time = new Date().getTime();
	//}

}*/


function setPlayerFGAStats(data, team) {
	setData('#dash_' + team + '_fgas', 
			genDashFGAStats(data['kickers'], data['fullteamname']));
}

function setPlayerKickoffStats(data, team) {
	setData('#dash_' + team + '_kickoffs',
			genDashKickoffStats(data['kickoffers'], data['fullteamname']));
}

function setPlayerPuntingStats(data, team) {
	setData('#dash_' + team + '_punting',
			genDashPuntingStats(data['punters'], data['fullteamname']));
}

function setPlayerReturnStats(data, team) {
	setData('#dash_' + team + '_returns',
			genDashReturnStats(data['allreturns'], data['fullteamname']));
}

function genDashKickoffStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	

	
	
	
	str =	'<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">';
	str +=	 '<tr>';
	str +=	  '<th width="80%" colspan="6" align="left">' + teamname + ' Kickoffs</th>';
	str +=	 '</tr>';
	str +=	 '<tr>';
	str +=	  '<th class="grey" width="20%">Name</th>';
	str +=	  '<th class="grey">No.</th>';
	str +=	  '<th class="grey">Yds</th>';
	str +=	  '<th class="grey">TB</th>';
	str +=	  '<th class="grey">OB</th>';
	str +=	  '<th class="grey">Avg.</th>';
	str +=	 '</tr>';
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';

	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['kickoffcnt'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['kickoffyds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['kickofftb'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['kickoffob'] + '</td>';
		var kickoffavg = val['kickoffcnt']!=0?Math.round(val['kickoffyds']*100/val['kickoffcnt'])/100:0;
		str += '<td class="dashrow' + bg + centered + '">' + kickoffavg + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	
	return str;
}



function genDashFGAStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	

	
	
	
	str =	'<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">';
	str +=	 '<tr>';
	str +=	  '<th width="80%" colspan="5" align="left">' + teamname + ' Field Goal Attempts</th>';
	str +=	 '</tr>';
	str +=	 '<tr>';
	str +=	  '<th class="grey" width="20%">Name</th>';
	str +=	  '<th class="grey">Qtr</th>';
	str +=	  '<th class="grey">Time</th>';
	str +=	  '<th class="grey">Distance</th>';
	str +=	  '<th class="grey">Result</th>';
	str +=	 '</tr>';
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';

	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['qtr'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['time'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['dist'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['result'] + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	
	return str;
}




function genDashPuntingStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	

	
	
	
	str =	'<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">';
	str +=	 '<tr>';
	str +=	  '<th width="80%" colspan="7" align="left">' + teamname + ' Punting</th>';
	str +=	 '</tr>';
	str +=	 '<tr>';
	str +=	  '<th class="grey" width="20%"></th>';
	str +=	  '<th class="grey">No.</th>';
	str +=	  '<th class="grey">Yds</th>';
	str +=	  '<th class="grey">Avg</th>';
	str +=	  '<th class="grey">Long</th>';
	str +=	  '<th class="grey">In20</th>';
	str +=	  '<th class="grey">TB</th>';
	str +=	 '</tr>';
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';

	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['punt'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['yds'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['avg'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['long'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['puntin20'] + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' + val['punttb'] + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}

function genDashReturnStats(data, teamname) {
	var str = '';
	var counter = 0;
	
	

	
	
	
	str =	'<table cellpadding="2" cellspacing="5" border="0" class="dash-stats" width="100%">';
	str +='<tr>';
	str +='<th width="80%" colspan="10" align="left">' + teamname + ' All Returns</th>';
	str +='</tr>';
	str +='<tr>';
	str +='<th class="grey" width="20%"></th>';
	str +='<th class="grey" colspan="3">Punts</th>';
	str +='<th class="grey" colspan="3">Kickoffs</th>';
	str +='<th class="grey" colspan="3">Interceptions</th>';
	str +='</tr>';
	str +='<tr>';
	str +='<th class="grey" width="20%"></th>';
	str +='<th class="grey">No.</th>';
	str +='<th class="grey">Yds</th>';
	str +='<th class="grey">Lg</th>';
	str +='<th class="grey">No.</th>';
	str +='<th class="grey">Yds</th>';
	str +='<th class="grey">Lg</th>';
	str +='<th class="grey">No.</th>';
	str +='<th class="grey">Yds</th>';
	str +='<th class="grey">Lg</th>';
	str +='</tr>';
	
	$.each(data, function(idx, val) {
		counter++;

		var bg = (counter % 2 == 0) ? '2' : '1';
		var centered = ' centertd';
		var vali;
	  str += '<tr>';
		str += '<td class="dashrow' + bg + '">' + val['name'] + '</td>';
		vali = (typeof(val['puntret']) != "undefined") ? val['puntret'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		vali = (typeof(val['puntyds']) != "undefined") ? val['puntyds'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		vali = (typeof(val['puntlong']) != "undefined") ? val['puntlong'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		vali = (typeof(val['kickret']) != "undefined") ? val['kickret'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		vali = (typeof(val['kickyds']) != "undefined") ? val['kickyds'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		vali = (typeof(val['kicklong']) != "undefined") ? val['kicklong'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		vali = (typeof(val['intret']) != "undefined") ? val['intret'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		vali = (typeof(val['intyds']) != "undefined") ? val['intyds'] : '0';
		str += '<td class="dashrow' + bg + centered + '">' + vali + '</td>';
		str += '<td class="dashrow' + bg + centered + '">' +  + '</td>';
		str += '</tr>';
	});

	str += '</table>';
	if (counter == 0) {
		str = "NONE";
	}
	return str;
}


