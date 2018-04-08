states["videos"]={
	handle: function(){
		loadVideosView();
	}
}
function loadVideosView(q) {
	if (!q){
		if (!currentQuarter){
			setTimeout(loadVideosView, 200, null);
			return;
		} else {
			q = currentQuarter;	
		}
	}
	if ((viewsStatus.videos.time + 30000) < new Date().getTime()) {
		videosScript.loadVideosByQuarter(q);
		viewsStatus.videos.time = new Date().getTime();
	}
}

var videosScript = {
	getQuaterAvailables : function(choice) {
		var text = '<select onchange="videosScript.changeVideosQuarter()" id="video_choices">';

		for ( var i = 1; i <= currentQuarter; i++) {
			if (i != choice)
				text += '<option value="' + i + '">' + i + '</option>';
			else
				text += '<option value="' + i + '" selected>' + i + '</option>';
		}

		text += '</select>';
		return text;
	},
	
	showFilters: function() {		
		var container = dojo.byId("videos-filter");
		if (container.hasAttribute("hide"))
			this.getChoices();
		else{
			container.setAttribute("hide","");
			videosScript.loadVideosByQuarter(currentQuarter);
		}
	},
	
	searchByType: function(event){
		var sel = dojo.byId("video_filters");
		
		var xhrArgs = {
			url : server_name
					+ "/service/get/videos/search.php",
			handleAs : "json",
			content : {
				search : "type",
				type: sel.value
			},
			load : videosScript.videosLoaded,
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		dojo.byId('videosContent').innerHTML = '<h3 dojoType="dojox.mobile.RoundRect" class="content-wait">Please wait while the data is being loaded ...</h3>';
		dojox.mobile.parser.parse(dojo.byId('videosContent'));
		//console.log("before parse");
		//dojox.mobile.parser.parse(dojo.byId('videosContent'));
		
		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
	},
	
	searchPlayer: function(event){
		var sel = dojo.byId("video_players");
		
		var xhrArgs = {
			url : server_name
					+ "/service/get/videos/search.php",
			handleAs : "json",
			content : {
				search : "player",
				playerid: sel.value
			},
			load : videosScript.videosLoaded,
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		dojo.byId('videosContent').innerHTML = '<h3 dojoType="dojox.mobile.RoundRect" class="content-wait">Please wait while the data is being loaded ...</h3>';
		dojox.mobile.parser.parse(dojo.byId('videosContent'));
		//console.log("before parse");
		//dojox.mobile.parser.parse(dojo.byId('videosContent'));
		
		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
	},
	
	getChoices: function() {
		
		var xhrArgs = {
			url : server_name
					+ "/service/get/videos/search.php",
			handleAs : "json",
			content : {
				choices: true
			},
			load : function(data) {
				var players = data['players'];
				var selectele = dojo.byId("video_players");
				var text = "";
				for (i in players){
					var player = players[i];
					if (player["number"]){
						text += "<option value=\""+player["id"]+"\">"
						text += player["fname"]+" "+player["lname"]+" #"+player["number"];						
						text += "</option>";
					}
				}
				//console.log(text);
				selectele.innerHTML = text;
				
				//dojo.byId("videos-filter").setAttribute("style","display: none;");
				dojo.byId("videos-filter").removeAttribute("hide");
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};	
		var deferred = dojo.xhrGet(xhrArgs);
	},
	
	getTypeFilters : function() {
		var text = '<select onchange="videosScript.changeVideosFilter()" id="video_filters">';
		
		text += '<option value="all">ALL</option>';
		text += '<option value="touchdown">Touchdown</option>';
		text += '<option value="fieldgoal">Field Goal</option>';
		text += '<option value="pass">Pass</option>';
		text += '<option value="penalty">Penalty</option>';
		text += '<option value="fumble">Fumble</option>';
		text += '<option value="interception">Interception</option>';

		text += '</select>';
		return text;
	},
	
	changeVideosQuarter : function() {
		var element = dojo.byId('video_choices');
		videosScript.loadVideosByQuarter(element.value);
	},
	
	changeVideosFilter: function(){
		//var element = dojo.byId('video_filter');	
	},
	
 	videosLoaded: function(data) {
		var text = '<ul dojoType="dojox.mobile.EdgeToEdgeList">'
					+'<li dojoType="dojox.mobile.RoundRect">'
					+'<table class="videos_table">';
		for ( var row in data) {
			text += videosScript.buildVideoRow(data[row]);
		}
		text += '</table></li></ul>';

		dojo.byId('videosContent').innerHTML = text;
		dojox.mobile.parser.parse(dojo.byId('videosContent'));
	},
	
	loadVideosByQuarter : function(q) {
		var xhrArgs = {
			url : server_name
					+ "/service/get/videos/getApprovedVideosByQuarterGameId.php",
			handleAs : "json",
			content : {
				gameid : gameId,
				quarter : q
			},
			load : videosScript.videosLoaded,
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};

		dojo.byId('videosContent').innerHTML = '<h3 dojoType="dojox.mobile.RoundRect" class="content-wait">Please wait while the data is being loaded ...</h3>';
		dojox.mobile.parser.parse(dojo.byId('videosContent'));
		
		dojo.byId('videos-quarter').innerHTML = 'Quarter: ' 
				+ videosScript.getQuaterAvailables(q) 
				+ '<span class="other_quarter">'
				+ '<div dojoType="dojox.mobile.Button" onclick="videosScript.showFilters()">Filter</div>'
				+ '</span>';
		
		dojox.mobile.parser.parse(dojo.byId('videos-quarter'));
		//dojo.byId('videos-quarter').innerHTML = 'Quarter : ' + q
		//		+ '<span class="other_quarter"><small>Change </small>'
		//		+ videosScript.getQuaterAvailables(q) + '</span>';
		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
	},

	buildVideoRow : function(data) {
		var text = "";
		for ( var i in data) {
			var style_class = (i % 2 == 0) ? 'even' : 'odd';
			var a = data[i].text.indexOf(':');
			var b = data[i].text.length;
			var id = data[i].text.substring(0, a);
			var detail = data[i].text.substring(a + 1, b);
		
			var aele = '<a href="/videos/'
					+ data[i].path
					+ 'small_mp4/'
					+ data[i].filename
					+ '.mp4" target="_blank"><img src="images/video_icon.png" class="videoicon"/>'
					+ detail + '</a>';
					
			text += '<tr class="play_item ' + style_class + '"><td><table class="full_width">'
					+ '<tr class="under_blue"><td>' + id
					+ '</td></tr><tr><td>'+aele+'</td></tr></table></td></tr>';
			
			/*text += '<li dojoType="dojox.mobile.RoundRect" class="video"><a href="/videos/'
					+ data[i].path
					+ 'small_mp4/'
					+ data[i].filename
					+ '.mp4" target="_blank"><img src="images/video_icon.png" class="videoicon"/>'
					+ data[i].text + '</a></li>';
			*/
		}
		return text;
		
		/*
		var text = "";
		var style_class = (index % 2 == 0) ? 'even' : 'odd';

		var a = data.text.indexOf(':');
		var b = data.text.length;
		var id = data.text.substring(0, a);
		var detail = data.text.substring(a + 1, b);

		text += '<tr class="play_item ' + style_class + '"><td><table class="full_width"><tr class="under_blue"><td>' + id
				+ '</td></tr><tr><td>'+detail+'</td></tr></table></td></tr>';
		*/
	},

	openVideo : function(path) {

	}
};
