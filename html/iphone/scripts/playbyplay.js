states["playbyplay"] = {
	handle : function() {
		loadPlayByPlayView();
	},
    fails: 0
}

function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var password=getCookie("password");
    if (password != "2016")
        {
        password = prompt("Please enter your password:","");
        if (password != "2016")
                {
                alert("Wrong password.");
                return 0;
                }
        else
                {
                setCookie("password",password,1);
                return 1;
                }

        }
    return 1;
}

function loadPlayByPlayView(q) {
	console.log("load play by play: "+q);	
	if (!q) {
		if (!currentQuarter) {
            states.playbyplay.fails++;
            if (states.playbyplay.fails<10)
                setTimeout(loadPlayByPlayView, 300, null);
			return;
		} else {
			q = currentQuarter;
		}
	}
	if ((viewsStatus.playbyplay.time + 30000) < new Date().getTime()) {
		playsScript.loadPlayByPlayByQuarter(q);
		viewsStatus.playbyplay.time = new Date().getTime();
	}
	// dojo.hash("playbyplay");
	// dojo.back.addToHistory(states["playbyplay"]);
}

var playsScript = {
	playVideo: function(event){
		event.preventDefault();
		event.stopPropagation();
		console.log("play video");
		
		
                var i = checkCookie();
                if (i == 0)
                        {return null;}

		
		var vidurl = $(this).attr("href");
		if (!vidurl){
		  //this is a play-row, find the link
		  vidurl = $(this).find(".play-vid-preview a").attr("href"); 
		}
		
		videoScript.showVideo(vidurl);
		
		return false;
	},
	showFilters: function() {		
		var container = $("#playbyplay-filter");
		console.log("show filters: "+container.attr("hide"));
		console.log("show filters");
		if (container.attr("hide")=="")
			this.getChoices();
		else{
			container.attr("hide","");
			playsScript.loadPlayByPlayByQuarter(currentQuarter);
		}
	},
	
	searchByType: function(event){
		var sel = $("#playbyplay_filters");
		
		$.ajax({
			url : server_name
					+ "/service/get/videos/search.php",
			contentType : "json",
			dataType : "json",
			data : {
				search : "type",
				type: sel.value
			},
			success : playsScript.videosLoaded,
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});

		$('#playbyplayContent').html('<h3 class="content-wait">Please wait while the data is being loaded ...</h3>');
		//dojox.mobile.parser.parse(dojo.byId('videosContent'));
		//console.log("before parse");
		//dojox.mobile.parser.parse(dojo.byId('videosContent'));
		
		// Call the asynchronous xhrGet
		//var deferred = dojo.xhrGet(xhrArgs);
	},
	
	searchPlayer: function(event){
		var sel = $("#video_players");
		
		$.ajax({
			url : server_name
					+ "/service/get/videos/search.php",
			contentType : "json",
			dataType: "json",
			data : {
				search : "player",
				playerid: sel.value
			},
			success : playsScript.videosLoaded,
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});

		$('#videosContent').html('<h3 class="content-wait">Please wait while the data is being loaded ...</h3>');
		//dojox.mobile.parser.parse(dojo.byId('videosContent'));
		//console.log("before parse");
		//dojox.mobile.parser.parse(dojo.byId('videosContent'));
		
		// Call the asynchronous xhrGet
		//var deferred = dojo.xhrGet(xhrArgs);
	},
	
	getChoices: function() {
		$.ajax({
			url : server_name
					+ "/service/get/videos/search.php",
			contentType : "json",
			dataType: "json",
			data : {
				choices: true
			},
			success : function(data) {
				var players = data['players'];
				var selectele = $("#playbyplay_players");
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
				selectele.html(text);
				
				//dojo.byId("videos-filter").setAttribute("style","display: none;");
				$("#playbyplay-filter").removeAttr("hide");
				
				$("#playbyplay-filter select").trigger("change");
				
				console.log("native?: "+$.mobile.selectmenu.prototype.options.nativeMenu);
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
	},
	
	getTypeFilters : function() {
		var text = '<select onchange="playsScript.changeVideosFilter()" id="playbyplay_filters">';
		
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

	changeQuarter : function() {
		console.log("change quarter");
		var element = $('#quarter-choices');
		if ($('#playbyplayContent').attr("quarter")!=element.val())
			playsScript.loadPlayByPlayByQuarter(element.val());
	},

	
	changeVideosFilter: function(){
		//var element = dojo.byId('video_filter');	
	},
	
 	videosLoaded: function(data) {
		var text = '<div><table>';//<table class="plays_table">';
		var counter = 0;
		for ( var row in data) {
			text += playsScript.buildPlayRow(data[row], counter);
			counter++;
		}
		text += '</table></div>';//'</table></div>';
		console.log("plays: "+counter);
		$('#playbyplayContent').html(text);
		$("#playbyplayContent a").click(playsScript.playVideo);
		$("#playbyplayContent .play-row").click(playsScript.playVideo);
		$("#playbyplayContent .play-row").bind("touch",playsScript.playVideo);
	},

	loadPlayByPlayByQuarter : function(q) {
		$.ajax({
			url : server_name
					+ "/service/get/playbyplay/getPlaysByGameIdQuarter.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				quarter : q
			},
			success : playsScript.videosLoaded,
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		$('#playbyplayContent').attr("quarter",q);
		$('#playbyplayContent').html('<h3>Please wait while the data is being loaded ...</h3>');
		console.log("quarter: "+q);
		$("#quarter-choices").val(q);
		//document.getElementById("quarter-choices").value = q;
		$("#quarter-choices").trigger("change");
		/*
			$('#playbyplay-quarter').html('Quarter: ' 
				+ playsScript.getQuaterAvailables(q) 
				+ '<span class="other_quarter">'
				+ '<div onclick="playsScript.showFilters()">Filter</div>'
				+ '</span>');
		*/

	},
    parsePlayText: function(text){
        var a = text.indexOf(':');
		var b = text.length;
		var id = text.substring(0, a);
		var detail = text.substring(a + 1, b);
		
		return [id,detail];  
    },
	buildPlayRow : function(data, index) {
		var text = "";
		var style_class = (index % 2 == 0) ? 'even' : 'odd';
        var playtxt = playsScript.parsePlayText(data.text);
        var id = playtxt[0];
        var detail = playtxt[1];
		

		var i=0;
		
	   
		/*text += '<tr class="play_item ' + style_class + '"><td><table class="full_width"><tr class="under_blue"><td>' + id
				+ '</td></tr><tr><td>'+detail+'</td><td>'+aele+
				'</td></tr></table></td></tr>';
		*/
		//text = '<div><div class="under_blue">'+id+'</div><div>'+aele+'</div>';
		var videle="",preview;
		var imgurl = "";

               	if(/kick attempt good/i.test(detail)){
		  imgurl = "kick good-bl-r.png"; 
                }
                else if(/kick attempt bad/i.test(detail)) { 
		  imgurl = "kick bad-bl-r.png";	
                }	   	  	
	        else if(/start of [0-9]/i.test(detail)) {
                  imgurl = "startQuarter.png";
                }
		else if(/end of [0-9]/i.test(detail)) {
		  imgurl = "endQuarter.png";
		}
		else if(/timeout/i.test(detail)) {
		  imgurl = "time out.png";
		}
		else if(/rush for [0-9]/i.test(detail)) {
		  imgurl = "rush gain.png";
		}
		else if(/rush for loss/i.test(detail)) {
		  imgurl = "rush loss.png";
		}
		else if(/pass incomplete/i.test(detail)) {
		  imgurl = "incomplete pass.png";
		}
		else if(/pass complete/i.test(detail)) {
		  imgurl = "pass.png";
		}
		else if(/end of game/i.test(detail)) {
		  imgurl = "end game.png";
		}
		else if(/start of game/i.test(detail)) {
		  imgurl = "start game.png";
		}	
          	/*
		  videle = '<div class="play-vid-preview"><a href="'+vid+'" target="_blank">'+
                   '<img src="http://estadium.gatech.edu/iphone/images/video.png" width="50" height="50"/></a></div>';
		} else if(/drive start/i.test(detail) == false &&
			/end of/i.test(detail) == false &&
			/timeout/i.test(detail) == false &&
			/start of/i.test(detail) == false &&
			/PENALTY/.test(detail) == false &&
			/ball on/.test(detail) == false) {
		  videle = '<div class="play-vid-filler"><img src="http://estadium.gatech.edu/iphone/images/video.png" width="50" height="50" style="opacity:0.4"/></div>'; */
		if(data["videos"]) {
		  var vid = videoScript.videoURL(data['videos'][i]);
		  preview = vid.replace(/\.mp4/,".jpg");
		  videle = '<div class="play-vid-preview"><a href="'+vid+'" target="_blank">';
		}
		else {
		  videle ='<div class="play-vid-filler">';
		}
		var vidstuff = videle+'<img src="http://estadium.gatech.edu/iphone/images/'+imgurl+'" width="50" height="50"/></a></div>';
		if (imgurl=='')
		{
		text = '<tr class="play-row"><td></td><td class="play-content"><div class="play-id">'+id+
        	'</div><div class="play-detail">'+
	        detail+'</div></td></tr>';
        }
		else
		{
			text = '<tr class="play-row"><td>'+vidstuff+
            	'</td><td class="play-content"><div class="play-id">'+id+
        	'</div><div class="play-detail">'+
	        detail+'</div></td></tr>';
		}
		return text;
	}
};
