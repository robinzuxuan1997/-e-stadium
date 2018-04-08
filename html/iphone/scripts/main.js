//change this variable to the server used
//var server_name = 'http://estaddev.vip.gatech.edu';
// global variables
var gameId, homeId, homeName, homeAcronym, homeLogoPath, visitorId, visitorName, visitorAcronym, visitorLogoPath;
var homeTotal, home1Q, home2Q, home3Q, home4Q, homeOQ, homeHasBall;
var visitorTotal, visitor1Q, visitor2Q, visitor3Q, visitor4Q, visitorOQ, awayHasBall;
var gameTime, gametStatusText;
var currentQuarter;

var viewsStatus = {
	homepage : {
		
	},
	videos : {
		time : 0
	},
	stats : {
		home :{
			time : 0
		},
		visitor:{
			time : 0
		}
	},
	homeplayerstats : {
		time : 0
	},
	visitorplayerstats : {
		time : 0
	},
	drivetracker : {
		time : 0
	},
	playbyplay : {
		time : 0
	},
	otherGames : {
		time : 0
	},
	
	dbhometeamstats : {
		time : 0
	},
	
	dbawayteamstats : {
		time : 0
	},
	
	dbawaydefensestats : {
		time : 0
	},
	
	dbhomedefensestats : {
		time : 0
	},
	
	dbawayststats : {
		time : 0
	},
	
	dbhomeststats : {
		time : 0
	}
};

var states = {};

$('body').bind('swipeleft',function(event, ui){
  //alert('Swipe left: '+ ui.nextPage);
  $(".goleft a").click();
});
$('body').bind('swiperight',function(event, ui){
  //alert('Swipe left: '+ ui.nextPage);
});

function asyncInit(){
	//getGameGeneralInfo();
	//getGameScoreBoardData();
	//getGameStatus();
	var currentpage = $.mobile.activePage.attr("id");
	//showPage(currentpage);
	
	getGameStatus();
	getGameScoreBoardData();
	getGameSummary();
	//$(".accordion .toggled").toggle();
	jQuery(document).ready(function(){
		function dotoggle() {
			var h = $(this);
			var hoff = $("#header").height();
			
			//console.log("scrollp: "+$("#stats").scrollview("getScrollPosition").y);
			//console.log("pos: "+h.offset().top+"|"+hoff+"|"+h.scrollTop());
			
			//s.scrollupdate(0,0);
			//$("#stats").scrollview("scrollTo",0,-(h.offset().top-hoff));
			$(this).next().toggle('fast');
			return false;
		}
		//listen for click and touchend because mobile doesn't send clicks for this action
		//$('.accordion .head').click(dotoggle).bind('touchend',dotoggle).next().hide();
		$('.accordion .head').click(dotoggle).next().hide();
	});
	$('.accordion .team-stats').show();
	
}

//Support back/forward
function showPage(value){
	console.log("show page: - "+value);
	for (var p in states){
		console.log("--"+p);	
	}
	if (value in states){
		states[value].handle();	
	}
}

function setGameStatus(){
	$(".game-quarter").html(gametStatusText);
	$(".game-time").html(gameTime);	
	updatePossession();
}
function updatePossession(){
	var pos=null, posother=null;
	if (homeHasBall){
		pos = $(".home .possession");
		posother = $(".away .possession"); 
	} else if (awayHasBall){
		pos = $(".away .possession");
		posother = $(".home .possession");	
	}
	//console.log("ball: "+homeHasBall+"|"+awayHasBall);
	if (pos!=null){
		if (pos.hasClass("hidden")){
			pos.removeClass("hidden");	
		}	
		if (!posother.hasClass("hidden")){
			posother.addClass("hidden");
		}
	} else {
		$(".possession").addClass("hidden");
	}	
}
function getGameStatus() {
	console.log("game-status gameid: "+gameid);
	$.ajax({
		url : server_name + "/service/get/global/getGameStatus.php",
		dataType: "json",
		data : {
			gameid : gameid
		},
		success : function(data) {
            console.log("game-status success!");
			homeHasBall = data['homeHasBall'];
			awayHasBall = data['visitorHasBall'];
			gametStatusText = data['text'];
			gameTime = data['time'];
			currentQuarter = data['quarter'];
            
            var recentplay = data['recentplay'];
            var playid="",playdetail="";
            if (recentplay){
                pt = playsScript.parsePlayText(recentplay);
                playid = pt[0];
                playdetail = pt[1];
            }
            console.log("recent play: "+recentplay+"-"+playid+"-"+playdetail);
            $(".recentplay .position").html(playid);
            $(".recentplay .playtext").html(playdetail);
            
			setGameStatus();

		},
		error : function(error) {
			console.log("An unexpected error occurred: " + error);
		}
	});
}

function adjustOT(){
	if(currentQuarter < 5){
		$('.score_board_over_time').addClass("hidden"); // hide;
	}else{
		$('.score_board_over_time').removeClass("hidden"); // show;
	}
}

function setScoreBoardData() {
	adjustOT();
	updatePossession();
	
	$(".home-score").html(homeTotal);
	$(".away-score").html(visitorTotal);
	
	$(".home .q1").html(home1Q);
	$(".home .q2").html(home2Q);
	$(".home .q3").html(home3Q);
	$(".home .q4").html(home4Q);
	$(".home .ot").html(homeOQ);
	if (currentQuarter>4)
		$(".home .ot").removeClass("hidden");
	else if (!$(".home .ot").hasClass("hidden"))
		$(".home .ot").addClass("hidden")	
	$(".home .totalscore").html(homeTotal);
	
	$(".away .q1").html(home1Q);
	$(".away .q2").html(home2Q);
	$(".away .q3").html(home3Q);
	$(".away .q4").html(home4Q);
	$(".away .ot").html(homeOQ);
	if (currentQuarter>4)
		$(".away .ot").removeClass("hidden");
	else if (!$(".away .ot").hasClass("hidden"))
		$(".away .ot").addClass("hidden")	
	$(".away .totalscore").html(homeTotal);
	
	//console.log("totals: "+homeTotal+" - "+visitorTotal);
	
	setTimeout(getGameScoreBoardData, 30*1000);

}

function getGameScoreBoardData() {
	// The parameters to pass to xhrGet, the url, how to handle it, and the
	// callbacks.
	$.ajax({
		url : server_name + "/service/get/global/getGameScoreBoardData.php",
		dataType : "json",
		data : {
			gameid : gameid
		},
		success : function(data) {
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
	});
}

function getGameSummary(){
    function addGameSummaryHeader(table,title){
        table.append("<tr><th colspan='2'>"+title+"</th>"+
            "<th>"+home.acrynm+"</th><th>"+away.acrynm+"</th>"+
            "</tr>");
    }
    function addGameSummaryHeaderDash(table,title){
	table.append("<tr><th class=\"grey\" colspan=\"4\">"+title+"</th><th class=\"grey\">"+home.acrynm+"</th><th class=\"grey\">"+away.acrynm+"</th>"+"</tr>");
    }
    $.ajax({
		url : server_name + "/service/get/global/drive_summary.php",
		dataType : "json",
		data : {
			gameid : gameid
		},
		success : function(data) {
            var table = $("#summary-table");
            table.empty();
	    if (isDashboard()) {
		table.append("<tr><th colspan=\"6\">Scoring Summary</th></tr>");
	    }
            quartertext=["First Quarter","Second Quarter",
                         "Third Quarter","Fourth Quarter","OT"];
            var quarter=0;
            
            //table.append("<colgroup><col/><col/><col class='sum-score'/><col class='sum-score'/></colgroup>");
			for (var i in data){
                var scores = data[i];

		if (isDashboard())
		{
			addGameSummaryHeaderDash(table, quartertext[(i>0&&i<5)?(i-1):4]);
		}else {
                addGameSummaryHeader(table,quartertext[(i>0&&i<5)?(i-1):4]);
		}

                for (var scoreidx in scores){
                    var score = scores[scoreidx];
                    var logo;
                    if (score.Team==home.id){
                        logo = home.logo;
                    } else {
                        logo = away.logo;
                    }
                    var textele="";
                    var vidurl="";
                    if ((score.Video && score.Video.path) && !isDashboard() ) {
                        //preview = "<img class='vidpreview' src='"+
                        //          videoScript.previewURL(score.Video)+"'/>";    
                        vidurl = videoScript.videoURL(score.Video);
                        //preview = "<a onclick='videoScript.previewClick(event)' "+
                        //    "'rel='external' class='vid-preview-a' href='"+vidurl+
                        //    "'><img class='vidpreview' src='"+
                        //    'images/video_icon.png'+"'/></a>"; 
                        textele = "<a target='estad-video' "+
                                  "onclick='videoScript.previewClick(event)' href='"+vidurl+"'>text</a>";
                    }   else {
                        textele = "text";
                    }
                    if (!isDashboard())
		    {
                    var text="<tr>"+
                        "<td><div>logo</div><div>scoretype</div><div>time</div></td>"+
                        "<td class='playbyplay-cell' >"+textele+"</td><td class='sum-score'>homescore</td><td class='sum-score'>awayscore</td>"+
                        "</tr>";
		    }
		    else
		    {
			var text = "<tr><td>logo</td><td>scoretype</td><td>time</td><td class=\"playbyplay-cell\">"+textele+"</td><td class=\"sum-score\">homescore</td><td class=\"sum-score\">awayscore<td></tr>"
		    }
                    text = text.replace("logo","<img class='logo' src='"+logo+"'/>")
                               .replace("scoretype",score.ScoreType)
                               .replace("time",score.ClockTime)
                               .replace("text",score.Text)
                               .replace("homescore",score.HScore)
                               .replace("awayscore",score.VScore);
                    table.append(text);
		    
                }
                
            }
		},
		error : function(error) {
			console.log("An unexpected error occurred: " + error);
		}
	});
}

function isDashboard()
{
	return ((window.location.href.indexOf("dashboard") != -1));
}

