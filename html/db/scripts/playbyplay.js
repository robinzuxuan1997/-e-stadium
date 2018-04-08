states.dashplaybyplay = {
	handle : function() {
		console.log("cq: " + currentQuarter);
		loadDashPlayByPlayView(currentQuarter);
		swReset('beg2');
		swStart('beg2','+');
	},
    fails: 0
}
var q1text = "";
var q2text = "";
var q3text = "";
var q4text = "";

var q1 = false;
var q2 = false;
var q3 = false;
var q4 = false;

var teeet = "";


function loadDashPlayByPlayView(q) {
	console.log("load play by play: "+q);
	if (!q) {
		if (!currentQuarter) {
            states.dashplaybyplay.fails++;
            if (states.dashplaybyplay.fails<10)
                setTimeout(loadDashPlayByPlayView(q), 300, null);
			return;
		} else {
			q = currentQuarter;
		}
	}
	if ( ((viewsStatus.playbyplay.time + 30000) < new Date().getTime()) || force_refresh ) {
		window.q1 = false;
		window.q2 = false;
		window.q3 = false;
		window.q4 = false;
		window.q1text = "";
		window.q2text = "";
		window.q3text = "";
		window.q4text = "";
		console.log("starting");
		dashplaysScript.loadPlayByPlays(q);
		viewsStatus.playbyplay.time = new Date().getTime();
	}
	// dojo.hash("playbyplay");
	// dojo.back.addToHistory(states["playbyplay"]);
}




var dashplaysScript = {

	playVideo: function(event){
		event.preventDefault();
		event.stopPropagation();
		console.log("play video");
		
		var vidurl = $(this).attr("href");
		if (!vidurl){
		  //this is a play-row, find the link
		  vidurl = $(this).find(".play-vid-preview a").attr("href"); 
		}
		
		videoScript.showVideo(vidurl);
		
		return false;
	},
	
	loadPlayByPlays : function(q) {
		var text = '<table width="1000" cellpadding="2" cellspacing="5" class="dash-stats">';//<table class="plays_table">';
		
		if (q == 2) { window.q3 = true; window.q4 = true; }
		if (q == 3) { window.q4 = true; }
		
		
		if (ascdesc == 0)
		{
		$.when(dashplaysScript.loadPlayByPlayByQuarter(1),
			 dashplaysScript.loadPlayByPlayByQuarter(2),
			 dashplaysScript.loadPlayByPlayByQuarter(3),
			 dashplaysScript.loadPlayByPlayByQuarter(4)
			).then(dashplaysScript.setPlayByPlay);
		}
		else
		{
			$.when(dashplaysScript.loadPlayByPlayByQuarterDesc(1),
			 dashplaysScript.loadPlayByPlayByQuarterDesc(2),
			 dashplaysScript.loadPlayByPlayByQuarterDesc(3),
			 dashplaysScript.loadPlayByPlayByQuarterDesc(4)
			).then(dashplaysScript.setPlayByPlayDesc);
		}	
		//text += window.test;
		//text += "</table>";
		//dashplaysScript.loadPlayByPlayByQuarter(4);
		
		
	},
	
	setPlayByPlay : function(data1, data2, data3, data4) {
		console.log("got to set ");
		var text = '<table width="1000" cellpadding="2" cellspacing="5" class="dash-stats">';
		
		if (null != data1)
		{
			var counter = 0;
			text += '<tr class="parent" id="q1pbprow"><th colspan="3" class="qheader">1st Quarter</th></tr>';
			
			for ( var row in data1[0]) {
			text += dashplaysScript.buildPlayRow(data1[0][row], counter, 1);
			counter++;
			}
		} else console.log("data1 is null");
		if (null != data2)
		{
			var counter = 0;
			text += '<tr class="parent" id="q2pbprow"><th colspan="3" class="qheader">2nd Quarter</th></tr>';
			
			for ( var row in data2[0]) {
			text += dashplaysScript.buildPlayRow(data2[0][row], counter, 2);
			counter++;
			}
		} else console.log("data2	 is null");
		if (null != data3)
		{
			var counter = 0;
			text += '<tr class="parent" id="q3pbprow"><th colspan="3" class="qheader">3rd Quarter</th></tr>';
			
			for ( var row in data3[0]) {
			text += dashplaysScript.buildPlayRow(data3[0][row], counter, 3);
			counter++;
			}
		} else console.log("data3 is null");
		if (null != data4)
		{
			var counter = 0;
			text += '<tr class="parent" id="q4pbprow"><th colspan="3" class="qheader">4th Quarter</th></tr>';
			
			for ( var row in data4[0]) {
			text += dashplaysScript.buildPlayRow(data4[0][row], counter, 4);
			counter++;
			}
		} else console.log("data4 is null");
		text += "</table>";
		
		console.log("text: " + text.length);
		$('#dash_playbyplay').html(text);
		$("#dash_playbyplay a").click(dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").click(dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").bind("touch",dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").css("cursor", "pointer");
		
		$(function() {
			$('tr.parent')
				.css("cursor","pointer")
				.attr("title","Click to expand/collapse")
				.click(function(){
					$(this).siblings('.child-'+this.id).toggle();
				}); 
			/* $('tr[@class^=child-]').hide().children('td');  */
		});
		
		/* $('tr[@class^=child-]').hide().children('td');	*/
		
		
	},
	
	
	setPlayByPlayDesc : function(data1, data2, data3, data4) {
		console.log("got to set ");
		var text = '<table width="1000" cellpadding="2" cellspacing="5" class="dash-stats">';
		
		
		
		if (null != data4)
		{
			var counter = 0;
			text += '<tr class="parent" id="q4pbprow"><th colspan="3" class="qheader">4th Quarter</th></tr>';
			
			for ( var row in data4[0]) {
			text += dashplaysScript.buildPlayRow(data4[0][row], counter, 4);
			counter++;
			}
		} else console.log("data4 is null");
		if (null != data3)
		{
			var counter = 0;
			text += '<tr class="parent" id="q3pbprow"><th colspan="3" class="qheader">3rd Quarter</th></tr>';
			
			for ( var row in data3[0]) {
			text += dashplaysScript.buildPlayRow(data3[0][row], counter, 3);
			counter++;
			}
		} else console.log("data3 is null");
		if (null != data2)
		{
			var counter = 0;
			text += '<tr class="parent" id="q2pbprow"><th colspan="3" class="qheader">2nd Quarter</th></tr>';
			
			for ( var row in data2[0]) {
			text += dashplaysScript.buildPlayRow(data2[0][row], counter, 2);
			counter++;
			}
		} else console.log("data2	 is null");
		if (null != data1)
		{
			var counter = 0;
			text += '<tr class="parent" id="q1pbprow"><th colspan="3" class="qheader">1st Quarter</th></tr>';
			
			for ( var row in data1[0]) {
			text += dashplaysScript.buildPlayRow(data1[0][row], counter, 1);
			counter++;
			}
		} else console.log("data1 is null");
		text += "</table>";
		
		console.log("text: " + text.length);
		$('#dash_playbyplay').html(text);
		$("#dash_playbyplay a").click(dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").click(dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").bind("touch",dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").css("cursor", "pointer");
		
		$(function() {
			$('tr.parent')
				.css("cursor","pointer")
				.attr("title","Click to expand/collapse")
				.click(function(){
					$(this).siblings('.child-'+this.id).toggle();
				}); 
			/* $('tr[@class^=child-]').hide().children('td');  */
		});
		
		/* $('tr[@class^=child-]').hide().children('td');	*/
		
		
	},
	
	setPlayText : function(q) {
		
		console.log(q + " got here");
		console.log("q1: " + q1);
		console.log("q2: " + q2);
		console.log("q3: " + q3);
		console.log("q4: " + q4);
			
		if (q1 && q2 && q3 && q4)
		
		{
			var text = '<table width="1000" cellpadding="2" cellspacing="5" class="dash-stats">';
			if (null != q)
			{
			
			
			text += q1text;
			text += q2text;
			text += q3text;
			text += q4text;


			text += "</table>";
			
			console.log("text: " + text.length);
			$('#dash_playbyplay').html(text);
			$("#dash_playbyplay a").click(dashplaysScript.playVideo);
			$("#dash_playbyplay .play-row").click(dashplaysScript.playVideo);
			$("#dash_playbyplay .play-row").bind("touch",dashplaysScript.playVideo);
			}
		}
		else if (q4)
		{
			setTimeout(dashplaysScript.setPlayText(q), 3000, null);
		}
	},
	

	loadPlayByPlayByQuarter : function(q) {
		$('#dash_playbyplay').html('<h3>Please wait while the data is being loaded ...</h3>');
		console.log("quarter: "+q);
		if (q <= currentQuarter)
		{
		 return $.ajax({
			url : server_name
					+ "/service/get/dashboard/getPlaysByGameIDQuarterASC.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				quarter : q
			}, 
			/*success : function(data) { dashplaysScript.videosLoaded(data, q) },*/
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		}
		else return null;
		//$('#dash_playbyplay').attr("quarter",q);
		//$("#quarter-choices").val(q);
		//document.getElementById("quarter-choices").value = q;
		//$("#quarter-choices").trigger("change");
		/*
			$('#playbyplay-quarter').html('Quarter: ' 
				+ dashplaysScript.getQuaterAvailables(q) 
				+ '<span class="other_quarter">'
				+ '<div onclick="dashplaysScript.showFilters()">Filter</div>'
				+ '</span>');
		*/

	},
	
	
		loadPlayByPlayByQuarterDesc : function(q) {
		$('#dash_playbyplay').html('<h3>Please wait while the data is being loaded ...</h3>');
		console.log("quarter: "+q);
		if (q <= currentQuarter)
		{
		 return $.ajax({
			url : server_name
					+ "/service/get/dashboard/getPlaysByGameIDQuarterDESC.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				quarter : q
			}, 
			/*success : function(data) { dashplaysScript.videosLoaded(data, q) },*/
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		});
		}
		else return null;
		//$('#dash_playbyplay').attr("quarter",q);
		//$("#quarter-choices").val(q);
		//document.getElementById("quarter-choices").value = q;
		//$("#quarter-choices").trigger("change");
		/*
			$('#playbyplay-quarter').html('Quarter: ' 
				+ dashplaysScript.getQuaterAvailables(q) 
				+ '<span class="other_quarter">'
				+ '<div onclick="dashplaysScript.showFilters()">Filter</div>'
				+ '</span>');
		*/

	},
	
	 videosLoaded: function(data, q) {
		//var text = '<table width="800" cellpadding="2" cellspacing="5">';//<table class="plays_table">';
		console.log(q + "is working");
		var text = '';
		var counter = 0;
		var qtext = '';
		if (q==1) qtext = '1st';
		if (q==2) qtext = '2nd';
		if (q==3) qtext = '3rd';
		if (q==4) qtext = '4th';
		window.teeet = data;
		text += '<tr><th colspan="3" class="qheader">' + qtext + ' Quarter</th></tr>';
		for ( var row in data) {
			text += dashplaysScript.buildPlayRow(data[row], counter);
			counter++;
		}
		//text += '</table>';
			if (q == 1 && !q1) { q1 = true; window.q1text = text; }
			if (q == 2 && !q2) { q2 = true; window.q2text = text; }
			if (q == 3 && !q3) { q3 = true; window.q3text = text; }
			if (q == 4 && !q4) { q4 = true; window.q4text = text; }

		console.log("plays: "+counter);
		console.log(q);
		
		//if (null != q) dashplaysScript.setPlayText(q);
		
		/*
		$('#dash_playbyplay').html(text);
		$("#dash_playbyplay a").click(dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").click(dashplaysScript.playVideo);
		$("#dash_playbyplay .play-row").bind("touch",dashplaysScript.playVideo);
		*/
	},
	
    parsePlayText: function(text){
        var a = text.indexOf(':');
		var b = text.length;
		var id = text.substring(0, a);
		var detail = text.substring(a + 1, b);
		
		return [id,detail];  
    },
	buildPlayRow : function(data, index, q) {
		//console.log("building row");
		var text = "";
		var style_class = (index % 2 == 0) ? 'even' : 'odd';
		var bg = (index % 2 == 0) ? '2' : '1';
        var playtxt = dashplaysScript.parsePlayText(data.text);
        var id = playtxt[0];
        var detail = playtxt[1];
		

		var i=0;
		
	   
		/*text += '<tr class="play_item ' + style_class + '"><td><table class="full_width"><tr class="under_blue"><td>' + id
				+ '</td></tr><tr><td>'+detail+'</td><td>'+aele+
				'</td></tr></table></td></tr>';
		*/
		//text = '<div><div class="under_blue">'+id+'</div><div>'+aele+'</div>';
		var videle="",preview;
		if (data["videos"]){
		  var vid = videoScript.videoURL(data['videos'][i]);
          //preview = vid.replace(/\.mp4/,".jpg");
		  vid = vid.replace("mobile_mp4", "raw");
		  videle = '<div class="dash_play-vid-preview"><a href="'+vid+'" target="_blank">'+
                   '<img src="http://estadium.gatech.edu/iphone/images/video.png" width="24" height="24"/></a></div>';
		} else if(/drive start/i.test(detail) == false &&
			/end of/i.test(detail) == false &&
			/timeout/i.test(detail) == false &&
			/start of/i.test(detail) == false &&
			/PENALTY/.test(detail) == false &&
			/ball on/.test(detail) == false) {
		  videle = '<div class="dash_play-vid-filler"><img src="http://estadium.gatech.edu/iphone/images/video.png" width="24" height="24" style="opacity:0.4"/></div>'; 
		}

        text = '<tr class="play-row child-q'+ q +'pbprow" style="display:none"><td class="dashrow' + bg + ' boldtd">'+videle+
            '</td><td class="play-content dashrow' + bg + ' boldtd"><div class="play-id">'+id+
            '</div></td><td class="dashrow' + bg + ' boldtd"><div class="play-detail">'+
            detail+'</div></td></tr>';
        //console.log(text);
		return text;
	}
};
