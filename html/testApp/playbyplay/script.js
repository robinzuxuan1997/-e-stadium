states["playbyplay"] = {
	handle : function() {
		loadPlayByPlayView();
	}
}
function loadPlayByPlayView(q) {
	if (!q) {
		if (!currentQuarter) {
			setTimeout(loadPlayByPlayView, 200, null);
			return;
		} else {
			q = currentQuarter;
		}
	}
	if ((viewsStatus.playbyplay.time + 30000) < new Date().getTime()) {
		playsScript.loadPlayByPLayByQuarter(q);
		viewsStatus.playbyplay.time = new Date().getTime();
	}
	// dojo.hash("playbyplay");
	// dojo.back.addToHistory(states["playbyplay"]);
}

var playsScript = {
	getQuaterAvailables : function(choice) {
		var text = '<select onchange="playsScript.changeVideosQuarter()" id="plays_choices">';

		for ( var i = 1; i <= currentQuarter; i++) {
			if (i != choice)
				text += '<option value="' + i + '">' + i + '</option>';
			else
				text += '<option value="' + i + '" selected>' + i + '</option>';
		}

		text += '</select>';
		return text;
	},

	changeVideosQuarter : function() {
		var element = dojo.byId('plays_choices');
		playsScript.loadPlayByPLayByQuarter(element.value);
	},

	loadPlayByPLayByQuarter : function(q) {
		var xhrArgs = {
			url : server_name
					+ "/service/get/playbyplay/getPlaysByGameIdQuarter.php",
			handleAs : "json",
			content : {
				gameid : gameId,
				quarter : q
			},
			load : function(data) {
				var text = '<ul dojoType="dojox.mobile.EdgeToEdgeList"><li dojoType="dojox.mobile.RoundRect"><table class="plays_table">';
				var counter = 0;
				for ( var row in data) {
					text += playsScript.buildPlayRow(data[row], counter);
					counter++;
				}
				text += '</table></li></ul>';

				dojo.byId('playbyplayContent').innerHTML = text;
				dojox.mobile.parser.parse(dojo.byId('playbyplayContent'));
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		dojo.byId('playbyplayContent').innerHTML = '<h3 dojoType="dojox.mobile.RoundRect">Please wait while the data is being loaded ...</h3>';
		dojo.byId('plays-quarter').innerHTML = 'Quarter : ' + q
				+ '<span class="other_quarter"><small>Change </small>'
				+ playsScript.getQuaterAvailables(q) + '</span>';
		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
	},

	buildPlayRow : function(data, index) {
		var text = "";
		var style_class = (index % 2 == 0) ? 'even' : 'odd';

		var a = data.text.indexOf(':');
		var b = data.text.length;
		var id = data.text.substring(0, a);
		var detail = data.text.substring(a + 1, b);

		text += '<tr class="play_item ' + style_class + '"><td><table class="full_width"><tr class="under_blue"><td>' + id
				+ '</td></tr><tr><td>'+detail+'</td></tr></table></td></tr>';
		

		return text;
	}
};
