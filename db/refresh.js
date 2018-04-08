var force_refresh = false;

function update_force_refresh()
{
	force_refresh = false;
}

function doPageUpdate() // page refresher
{
	var currentpage = $.mobile.activePage.attr("id");
	console.log("current page is #" + currentpage);
	
	force_refresh = true;
	
	if (currentpage == "gamestats")
	{
				$.when(
				loadOffensiveStatsView(),
				loadPlayerOffensiveStats()).then(update_force_refresh());
				console.log("Gamestats updated!");
	}
	
	if (currentpage == "scoring")
	{	
				
				$.when(
				getGameSummary()).then(update_force_refresh());
				console.log("Scoring updated!");
	}
	
	if (currentpage == "defense")
	{
		$.when(
		loadDefenseStatsView()).then(update_force_refresh());
		console.log("Defense updated!");
	}
	
	if (currentpage == "teamstats")
	{
			$.when(
			loadTeamStatsView()).then(update_force_refresh());
			console.log("Teamstats Updated!");
	}

	if (currentpage == "specialteams")
	{
		$.when(
		loadSpecialTeamsStatsView()).then(update_force_refresh());
		console.log("Special Teams updated!");
	}
	
	if (currentpage == "dashplaybyplay")
	{
		console.log("cq: " + currentQuarter);
		$.when(
		loadDashPlayByPlayView(currentQuarter)).then(update_force_refresh());
		console.log("Play By Play Updated!");
	}
	
	if (currentpage =="drivetracker")
	{
			$.when(
			loadDriveTrackerView()).then(update_force_refresh());
			console.log("Drivetracker updated!");
	}	
	
}
