states["teamstats"] = {
	handle : function() {
		// alert("Stats!");
		loadTeamStatsView();
		swReset('beg2');
		swStart('beg2','+');
		
	}
}

function loadTeamStatsView() {
	loadHomeTeamStatsView();
	loadAwayTeamStatsView();
	setTimeout(loadTeamStatsView, 60*1000);
}

function loadHomeTeamStatsView() {
	if ( ((viewsStatus.dbhometeamstats.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/dashboard/teamstats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : homeid
			},
			success : function(data) {
				setTeamStats(data, 'home');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.dbhometeamstats.time = new Date().getTime();
	}
}

function loadAwayTeamStatsView() {
	if ( ((viewsStatus.dbawayteamstats.time + 30000) < new Date().getTime()) || force_refresh ) {
		$.ajax({
			url : server_name + "/service/get/dashboard/teamstats.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				teamid : awayid
			},
			success : function(data) {
				setTeamStats(data, 'away');
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		viewsStatus.dbawayteamstats.time = new Date().getTime();
	}
}


function setTeamStats(data, team) {
  console.log("Setting teamstats");
	setData('#teamstats_' + team + '_firstdowns', data['first_downs']);
	setData('#teamstats_' + team + '_rushfd', data['rush_fd']);
	setData('#teamstats_' + team + '_passfd', data['pass_fd']);
	setData('#teamstats_' + team + '_penaltyfd', data['penalty_fd']);
	setData('#teamstats_' + team + '_netydrush', data['net_rush_yds']);
	setData('#teamstats_' + team + '_rushatt', data['rush_att']);
	setData('#teamstats_' + team + '_rushavg', data['rush_att']!=0?Math.round(data['net_rush_yds']*100 / data['rush_att'])/100:0);
	setData('#teamstats_' + team + '_rushtd', data['rush_td']);
	setData('#teamstats_' + team + '_rushgained', data['rush_gained']);
	setData('#teamstats_' + team + '_rushlost', data['rush_lost']);
	setData('#teamstats_' + team + '_netydpass', data['net_pass_yds']);
	setData('#teamstats_' + team + '_passcomp', data['pass_comp'] + '-' + data['pass_att'] + '-' + data['pass_int']);
	setData('#teamstats_' + team + '_avgperatt', data['pass_att']!=0?Math.round(data['net_pass_yds']*100 / data['pass_att'])/100:0);
	setData('#teamstats_' + team + '_avgpercomp', data['pass_comp']!=0?Math.round(data['net_pass_yds']*100 / data['pass_comp'])/100:0);
	setData('#teamstats_' + team + '_passtd', data['pass_td']);
	setData('#teamstats_' + team + '_totoffyds', data['tot_off_yds']);
	setData('#teamstats_' + team + '_totoffplays', data['rush_att'] + data['pass_att']);
	setData('#teamstats_' + team + '_avggain', ((data['pass_att'] != 0)||(data['rush_att'] !=0))?Math.round( (data['net_rush_yds']+data['net_pass_yds'])*100 / (data['rush_att'] + data['pass_att']) )/100:0);
	setData('#teamstats_' + team + '_fumblelost', data['fumble_cnt'] + '-' + data['fumble_lost']);
	setData('#teamstats_' + team + '_penalty', data['penalty_cnt'] + '-' + data['penalty_yds']);
	setData('#teamstats_' + team + '_puntyds', data['punt_cnt'] + '-' + data['punt_yds']);
	setData('#teamstats_' + team + '_puntavg', data['punt_cnt']!=0?Math.round(data['punt_yds']*100 / data['punt_cnt'])/100:0);
	setData('#teamstats_' + team + '_puntin20', data['punt_in20']);
	setData('#teamstats_' + team + '_puntplus50', data['punt_plus50']);
	setData('#teamstats_' + team + '_punttb', data['punt_tb']);
	setData('#teamstats_' + team + '_puntfc', data['punt_fc']);
	setData('#teamstats_' + team + '_kickyds', data['kick_cnt'] + '-' + data['kick_yds']);
	setData('#teamstats_' + team + '_kickavg', data['kick_cnt']!=0?Math.round(data['kick_yds']*100 / data['kick_cnt'])/100:0);
	setData('#teamstats_' + team + '_kicktb', data['kick_tb']);
	setData('#teamstats_' + team + '_puntretyds', data['punt_ret_cnt'] + '-' + data['punt_ret_yds'] + '-' + data['punt_ret_td']);
	setData('#teamstats_' + team + '_puntretavg', data['punt_ret_cnt']!=0?Math.round(data['punt_ret_yds']*100 / data['punt_ret_cnt'])/100:0);
	setData('#teamstats_' + team + '_kickretyds', data['kick_ret_cnt'] + '-' + data['kick_ret_yds'] + '-' + data['kick_ret_td']);
	setData('#teamstats_' + team + '_kickretavg', data['kick_ret_cnt']!=0?Math.round(data['kick_ret_yds']*100 / data['kick_ret_cnt'])/100:0);
	setData('#teamstats_' + team + '_intyds', data['int_cnt'] + '-' + data['int_yds'] + '-' + data['int_td']);
	setData('#teamstats_' + team + '_fretyds', data['fumble_ret_cnt'] + '-' + data['fumble_ret_yds'] + '-' + data['fumble_ret_td']);
	setData('#teamstats_' + team + '_miscyds', data['misc_yds']);
	setData('#teamstats_' + team + '_top', data['top']);
	setData('#teamstats_' + team + '_3rd', data['third_conv'] + ' of ' + data['third_att']);
	setData('#teamstats_' + team + '_4th', data['fourth_conv'] + ' of ' + data['fourth_att']);
	setData('#teamstats_' + team + '_rz', data['rz_conv'] + ' of ' + data['rz_att']);
	setData('#teamstats_' + team + '_sacksby', data['sacksby_cnt'] + ' of ' + data['sacksby_yds']);
	setData('#teamstats_' + team + '_pat', data['pat_conv'] + ' of ' + data['pat_att']);
	setData('#teamstats_' + team + '_fg', data['fg_conv'] + ' of ' + data['fg_att']);
}
