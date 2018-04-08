states["otherscores"] = {
	handle : function() {
		// alert("Other Scores!");
		loadOtherScoresView();
	}
}
function loadOtherScoresView() {
	// if (viewStatus.otherGames.time == 0){
	// loadOtherScoresTitles();
	// }
	if ((viewsStatus.otherGames.time + 30000) < new Date().getTime()) {
		loadScoresByType('ncf');
		viewsStatus.otherGames.time = new Date().getTime();
	}
	// dojo.hash("otherscores");
	// dojo.back.addToHistory(states["otherscores"]);
}

function generateScoreGame(data) {
	var str = '<table class="score_game">';
	str += '	<tr class="game_status">';
	str += '		<th>' + data.game_status + '</th>';
	str += '	</tr>';
	str += '	<tr>';
	str += '		<td class="visitor_name">' + data.visitor_name + '</td>';
	str += '		<td class="visitor_score">' + data.visitor_score + '</td>';
	str += '	</tr>';
	str += '	<tr>';
	str += '		<td class="home_name">' + data.home_name + '</td>';
	str += '		<td class="home_score">' + data.home_score + '</td>';
	str += '	</tr>';
	str += '</table>';

	return str;
}

function isInteger(s) {
	return (s.toString().search(/^-?[0-9]+$/) == 0);
}

function gameDataObjectFromText(data) {
	var a = data['team1'].lastIndexOf(' ');
	var b = data['team1'].length;
	var c = data['team2'].lastIndexOf(' ');
	var d = data['team2'].length;

	if (isInteger(data['team1'].substring(a+1, b))){
		var result = {
				game_status : data['result'],
				visitor_name : data['team1'].substring(0, a),
				visitor_score : data['team1'].substring(a+1, b),
				home_name : data['team2'].substring(0, c),
				home_score : data['team2'].substring(c+1, d)
			};
	}else{
		var result = {
				game_status : data['result'],
				visitor_name : data['team1'],
				visitor_score : ' ',
				home_name : data['team2'],
				home_score : ' '
			};
	}	

	return result;
}

// service/get/otherscores/getOtherScoreByTitle.php?scores
function loadScoresByType(aType) {
	var xhrArgs = {
		url : server_name + "/service/get/otherscores/getOtherScoreByTitle.php",
		handleAs : "json",
		content : {
			scores : aType
		},
		load : function(data) {
			// TODO
			var container = dojo.byId("othergamesContent");
			while (container.lastChild)
				container.removeChild(container.lastChild);

			var games = data["scores"];
			var top25table;
			if (aType == 'ncf') {
//				var header = document.createElement("h2");
//				header.innerHTML = "Top 25";
//				container.appendChild(header);
				top25table = document.createElement("table");
				container.appendChild(top25table);
//				var header2 = document.createElement("h2");
//				header2.innerHTML = "Other Games";
//				container.appendChild(header2);
			}

			var table = document.createElement("table");
			// border="1" bordercolor="red"
			table.setAttribute("border", "1");
			table.setAttribute("bordercolor", "black");
			table.setAttribute("cellspacing", "0");
			container.appendChild(table);
			for ( var i = 0; i < games.length; i++) {
				var game = games[i];

				var tr = document.createElement("tr");

				// var td1 = document.createElement("td")
				// var td2 = document.createElement("td");
				// td1.innerHTML = game["team1"] + "<br/>" + game["team2"];
				// td2.innerHTML = game["result"];
				// tr.appendChild(td1);
				// tr.appendChild(td2);
				var td = document.createElement("td");
				td.innerHTML = generateScoreGame(gameDataObjectFromText(game));

				tr.appendChild(td);

				// Check if in the top 25 of ncaa
				var re = /\(([0-9]|[0-9][0-9])\)/;
				if (aType == 'ncf'
						&& (game["team1"].match(re) || game["team2"].match(re))) {
					top25table.appendChild(tr);
				} else
					table.appendChild(tr);

				dojox.mobile.parser.parse(tr);

				/*
				 * // var gameEle = document.createElement("div"); //
				 * gameEle.setAttribute("class","other-game-score-box"); //
				 * gameEle.setAttribute("dojoType","dojox.mobile.Button"); //
				 * var ul = document.createElement("ul"); // var team1Ele =
				 * document.createElement("li"); // var team2Ele =
				 * document.createElement("li"); // var resultEle =
				 * document.createElement("li");
				 *  // team1Ele.innerHTML = game["team1"]; // team2Ele.innerHTML =
				 * game["team2"]; // resultEle.innerHTML = game["result"];
				 *  // ul.appendChild(team1Ele); // ul.appendChild(team2Ele); //
				 * ul.appendChild(resultEle); // gameEle.appendChild(ul);
				 *  // var placeHolder = document.createElement("div"); //
				 * container.appendChild(placeHolder);
				 *  // container.appendChild(gameEle); //
				 * dojox.mobile.parser.parse(gameEle);
				 */
			}
		},
		error : function(error) {
			console.log("An unexpected error occurred: " + error);
		}
	};

	// Call the asynchronous xhrGet
	var deferred = dojo.xhrGet(xhrArgs);
}

function loadOtherScoresTitles() {
	var xhrArgs = {
		url : server_name + "/service/get/otherscores/getOtherScoresTitles.php",
		handleAs : "json",
		content : {},
		load : function(data) {
			var header = dojo.byId("sportheader");
			for ( var sport in data) {
				var sportEle = document.createElement("div");
			}
		},
		error : function(error) {
			console.log("An unexpected error occurred: " + error);
		}
	};

	// Call the asynchronous xhrGet
	var deferred = dojo.xhrGet(xhrArgs);
}

var otherscores = {
	switchSport : function(event) {
		// dojo.hash("otherscores");
		var sport = event.target.getAttribute("value");
		loadScoresByType(sport);
	}
}
