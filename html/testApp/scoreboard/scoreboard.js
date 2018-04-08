/**
 * @author arnaldo
 */

function getGameStatus() {
	// The parameters to pass to xhrGet, the url, how to handle it, and the
	// callbacks.
	var xhrArgs = {
		url : server_name + "/service/get/global/getGameStatus.php",
		handleAs : "json",
		content : {
			gameid : gameId
		},
		load : function(data) {

			homeHasBall = data['homeHasBall'];
			visitorHasBall = data['visitorHasBall'];
			gametStatusText = data['text'];
			gameTime = data['time'];
			currentQuarter = data['quarter'];

			setGameStatus();

		},
		error : function(error) {
			console.log("An unexpected error occurred: " + error);
		}
	};

	// Call the asynchronous xhrGet
	var deferred = dojo.xhrGet(xhrArgs);
}



function setGameStatus() {
	adjustOT();
	
	if (homeHasBall) {
		dojo.query('.home_has_ball').forEach(function(e) {
			e.innerHTML = '<img src="/images/PossessionIcon.png"/>';
		});
		dojo.query('.visitor_has_ball').forEach(function(e) {
			e.innerHTML = '';
		});
	} else {
		dojo.query('.visitor_has_ball').forEach(function(e) {
			e.innerHTML = '<img src="/images/PossessionIcon.png"/>';
		});
		dojo.query('.home_has_ball').forEach(function(e) {
			e.innerHTML = '';
		});
	}

	dojo.query('.game_status_text').forEach(function(e) {
		e.innerHTML = gametStatusText;
	});

	dojo.query('.time_left').forEach(function(e) {
		e.innerHTML = gameTime;
	});

	setTimeout(getGameStatus, 30*1000);
}

function setGameGeneralInfo() {
	adjustOT();
	dojo.query('.visitor_logo').forEach(
			function(e) {
				e.innerHTML = '<img width="42" height="42" src="'
						+ visitorLogoPath + '"/>';
			});
	dojo.query('.home_logo').forEach(
			function(e) {
				e.innerHTML = '<img width="42" height="42" src="'
						+ homeLogoPath + '"/>';
			});

	dojo.query('.visitor_name').forEach(function(e) {
		e.innerHTML = visitorName;
	});
	dojo.query('.home_name').forEach(function(e) {
		e.innerHTML = homeName;
	});

}

function getGameGeneralInfo(callBack) {
	// The parameters to pass to xhrGet, the url, how to handle it, and the
	// callbacks.
	var xhrArgs = {
		url : server_name + "/service/get/global/getGameGeneralInfo.php",
		handleAs : "json",
		load : function(data) {
			gameId = data['gameId'];

			homeId = data['homeId'];
			homeName = data['homeName'];
			homeAcronym = data['homeAcronym'];
			homeLogoPath = data['homeLogoPath'];

			visitorId = data['visitorId'];
			visitorName = data['visitorName'];
			visitorAcronym = data['visitorAcronym'];
			visitorLogoPath = data['visitorLogoPath'];
			
			currentQuarter = data['quarter'];

			setGameGeneralInfo();
			callBack();

		},
		error : function(error) {
			console.log("An unexpected error occurred: " + error);
		}
	};

	// Call the asynchronous xhrGet
	var deferred = dojo.xhrGet(xhrArgs);
};

function setScoreBoardData() {
	adjustOT();
	
	if (homeHasBall) {
		dojo.query('.home_has_ball').forEach(function(e) {
			e.innerHTML = '<img src="/images/PossessionIcon.png"/>';
		});
		dojo.query('.visitor_has_ball').forEach(function(e) {
			e.innerHTML = '';
		});
	} else {
		dojo.query('.visitor_has_ball').forEach(function(e) {
			e.innerHTML = '<img src="/images/PossessionIcon.png"/>';
		});
		dojo.query('.home_has_ball').forEach(function(e) {
			e.innerHTML = '';
		});
	}

	// home

	dojo.query('.home_quarter_1').forEach(function(e) {
		e.innerHTML = home1Q;
	});
	dojo.query('.home_quarter_2').forEach(function(e) {
		e.innerHTML = home2Q;
	});
	dojo.query('.home_quarter_3').forEach(function(e) {
		e.innerHTML = home3Q;
	});
	dojo.query('.home_quarter_4').forEach(function(e) {
		e.innerHTML = home4Q;
	});
	dojo.query('.home_quarter_ot').forEach(function(e) {
		e.innerHTML = homeOQ;
	});
	dojo.query('.score_board_home_total').forEach(function(e) {
		e.innerHTML = homeTotal;
	});

	// visitor

	dojo.query('.visitor_quarter_1').forEach(function(e) {
		e.innerHTML = visitor1Q;
	});
	dojo.query('.visitor_quarter_2').forEach(function(e) {
		e.innerHTML = visitor2Q;
	});
	dojo.query('.visitor_quarter_3').forEach(function(e) {
		e.innerHTML = visitor3Q;
	});
	dojo.query('.visitor_quarter_4').forEach(function(e) {
		e.innerHTML = visitor4Q;
	});
	dojo.query('.visitor_quarter_ot').forEach(function(e) {
		e.innerHTML = visitorOQ;
	});
	dojo.query('.score_board_visitor_total').forEach(function(e) {
		e.innerHTML = visitorTotal;
	});

	// acronyms

	dojo.query('.score_board_home_acronym').forEach(function(e) {
		e.innerHTML = homeAcronym;
	});
	dojo.query('.score_board_visitor_acronym').forEach(function(e) {
		e.innerHTML = visitorAcronym;
	});
	
	setTimeout(getGameScoreBoardData, 30*1000);

};

function adjustOT(){
	if(currentQuarter < 5){
		dojo.query('.score_board_over_time').style({ display:"none" }); // hide;
	}else{
		dojo.query('.score_board_over_time').style({ display:"" }); // show;
	}
}

function getGameScoreBoardData() {
	// The parameters to pass to xhrGet, the url, how to handle it, and the
	// callbacks.
	var xhrArgs = {
		url : server_name + "/service/get/global/getGameScoreBoardData.php",
		handleAs : "json",
		content : {
			gameid : gameId
		},
		load : function(data) {
			currentQuarter = data['quarter'];

			homeTotal = data['homeData']['total'];
			home1Q = data['homeData']['firstQ'];
			home2Q = data['homeData']['secondQ'];
			home3Q = data['homeData']['thirdQ'];
			home4Q = data['homeData']['fourthQ'];
			homeOQ = data['homeData']['overQ'];
			homeHasBall = data['homeData']['hasBall'];

			visitorTotal = data['visitorData']['total'];
			visitor1Q = data['visitorData']['firstQ'];
			visitor2Q = data['visitorData']['secondQ'];
			visitor3Q = data['visitorData']['thirdQ'];
			visitor4Q = data['visitorData']['fourthQ'];
			visitorOQ = data['visitorData']['overQ'];
			visitorHasBall = data['visitorData']['hasBall'];

			setScoreBoardData();

		},
		error : function(error) {
			console.log("An unexpected error occurred: " + error);
		}
	};

	// Call the asynchronous xhrGet
	var deferred = dojo.xhrGet(xhrArgs);
};
