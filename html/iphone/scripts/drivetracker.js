states.drivetracker=
{
	handle: function()
	{
		loadDriveTrackerView();
	}
};

function loadDriveTrackerView()
{
	if ((viewsStatus.drivetracker.time + 30000) < new Date().getTime())
	{
		drivetracker.init();
		viewsStatus.drivetracker.time = new Date().getTime();	
	}
	drivetracker.init();
}

//for Show Quarters (top right button)
function goBut()
{
	$.mobile.changePage($("#button"), "slide", true, true);
	//$.mobile.changePage("#button");
}

var drivethis;
var quarterthis;
var curQuart;

var initCount = 0;


//setCurQuart: function(quart)
//{
//	curQuart = quart;
//}


var drivetracker =
{
	display: null,
	drive: null,
	init: function()
	{
		this.display = new DriveTrackerDisplay();
		//this.loadDrive();
		//this.loadDrives(20); //default
		//this.loadDrivesQT1();
		//this.loadDrivesQT2();
		//this.loadDrivesQT3();
		//this.loadDrivesQT4();
		
		if (initCount == 0)
		{
			this.display.init();
			this.update();
			
			this.loadDrivesQT1();
			this.loadDrivesQT2();
			this.loadDrivesQT3();
			this.loadDrivesQT4();
		}
		
		$("#drive-details .play-row").bind("click touch",playsScript.playVideo);
		$("#drive-details #view-video").bind("click",function(event){
		    playsScript.playVideo.apply($("#drive-details a"),[event]);
		});
		$("#drive-details #prev-video").bind("click",function(event){
		  drivetracker.display.highlightPrevious(); 
		});
		$("#drive-details #next-video").bind("click",function(event){
		  drivetracker.display.highlightNext(); 
		});
		$("#drive-details #hide-details").bind("click",function(event){
		  $("#drive-details").addClass("hidden");
		});
		
		
		$("#drivetracker-drives").bind("click touch", function(event)
		{
			var target = event.target;
			var type; var count=0;
			do{
				type = target.tagName.toLowerCase();
				if (type!="tr"){
					target=target.parentNode;
				}
				count++;
			} while(count<3 && type!="tr");
		
			if (type.toLowerCase()=="tr"){
				drivetracker.loadDrive(target.getAttribute("value"),target.getAttribute("idx"));
			}
			
			var check = target.getAttribute("value");
			
			var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						if (drive.driveid == check)
						{
							if (drive.quarter == 1)
							{
								drivetracker.loadDrivesQT1HL(drive.driveid);
								$.mobile.changePage("#drivetrackerQT1");
								//window.location.href = '#drivetrackerQT1';
							}
							else if (drive.quarter == 2)
							{
								drivetracker.loadDrivesQT2HL(drive.driveid);
								$.mobile.changePage("#drivetrackerQT2");
								//window.location.href = '#drivetrackerQT2';
							}
							else if (drive.quarter == 3)
							{
								drivetracker.loadDrivesQT3HL(drive.driveid);
								$.mobile.changePage("#drivetrackerQT3");
								//window.location.href = '#drivetrackerQT3';
							}
							else if (drive.quarter == 4)
							{
								drivetracker.loadDrivesQT4HL(drive.driveid);
								$.mobile.changePage("#drivetrackerQT4");
								return false;
								//$.mobile.changePage( $("#drivetrackerQT4"));
								//window.location.href = '#drivetrackerQT4';
							}
						}
					}		
				}//sucess
			}//xhrArgs
			var deferred = $.ajax(xhrArgs);
		  //console.log("target: "+target+" "+event.relatedTarget);
		});
		
		$("#drivetracker-drivesQT1").bind("click touch", function(event){
		//drivetracker.driveChanged(event);
			var target = event.target;
			var type; var count=0;
			do{
				type = target.tagName.toLowerCase();
				if (type!="tr"){
					target=target.parentNode;
				}
				count++;
			} while(count<3 && type!="tr");
		
			if (type.toLowerCase()=="tr"){
				drivetracker.loadDrive(target.getAttribute("value"),target.getAttribute("idx"));
			}
			
			var check = target.getAttribute("value"); //driveid;
			
			var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];

					for(var i=drives.length-1;i>=0;i--){
						
						if (drives[i].driveid == check)
						{
							var nowdrive=drives[i];
							drivethis = i;
							quarterthis = nowdrive.quarter;
						}
					}
					//window.location.href = '#drivetracker';
					//$.mobile.changePage($("#drivetracker"), "slide", true, true);
					drivetracker.loadDrives(check); //sending in driveid
					initCount = 1;
					$.mobile.changePage("#drivetracker");
                                        //var curquarter = drive.quarter;

			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	

		});
		
		$("#drivetracker-drivesQT2").bind("click touch", function(event){
		//drivetracker.driveChanged(event);
			var target = event.target;
			var type; var count=0;
			do{
				type = target.tagName.toLowerCase();
				if (type!="tr"){
					target=target.parentNode;
				}
				count++;
			} while(count<3 && type!="tr");
		
			if (type.toLowerCase()=="tr"){
				drivetracker.loadDrive(target.getAttribute("value"),target.getAttribute("idx"));
			}
			
			var check = target.getAttribute("value");
			var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];

					for(var i=drives.length-1;i>=0;i--){
						
						if (drives[i].driveid == check)
						{
							var nowdrive=drives[i];
							drivethis = i;
							quarterthis = nowdrive.quarter;
						}
					}
					drivetracker.loadDrives(check); //sending in driveid
					initCount = 1;
					$.mobile.changePage("#drivetracker");
                                        //var curquarter = drive.quarter;

			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	
			
		  //console.log("target: "+target+" "+event.relatedTarget);
		});
		
		$("#drivetracker-drivesQT3").bind("click touch", function(event){
		//drivetracker.driveChanged(event);
			var target = event.target;
			var type; var count=0;
			do{
				type = target.tagName.toLowerCase();
				if (type!="tr"){
					target=target.parentNode;
				}
				count++;
			} while(count<3 && type!="tr");
		
			if (type.toLowerCase()=="tr"){
				drivetracker.loadDrive(target.getAttribute("value"),target.getAttribute("idx"));
			}
			
			var check = target.getAttribute("value");
			var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];

					for(var i=drives.length-1;i>=0;i--){
						
						if (drives[i].driveid == check)
						{
							var nowdrive=drives[i];
							drivethis = i;
							quarterthis = nowdrive.quarter;
						}
					}
					drivetracker.loadDrives(check); //sending in driveid
					initCount = 1;
					$.mobile.changePage("#drivetracker");
					
                                        //var curquarter = drive.quarter;
					//window.location.href = '#drivetracker';

			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	
			
		  //console.log("target: "+target+" "+event.relatedTarget);
		});
		
		$("#drivetracker-drivesQT4").bind("click touch", function(event){
		//drivetracker.driveChanged(event);
			var target = event.target;
			var type; var count=0;
			do{
				type = target.tagName.toLowerCase();
				if (type!="tr"){
					target=target.parentNode;
				}
				count++;
			} while(count<3 && type!="tr");
		
			if (type.toLowerCase()=="tr"){
				drivetracker.loadDrive(target.getAttribute("value"),target.getAttribute("idx"));
				
			}
			
			var check = target.getAttribute("value");
			var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];

					for(var i=drives.length-1;i>=0;i--){
						
						if (drives[i].driveid == check)
						{
							var nowdrive=drives[i];
							drivethis = i;
							quarterthis = nowdrive.quarter;
						}
					}
					initCount = 1;
					drivetracker.loadDrives(check); //sending in driveid
					$.mobile.changePage("#drivetracker");
					return false;
					
					
					//$.mobile.changePage( "#drivetracker", {
					//			transition: "slideup",
					//			reverse: true,
					//			changeHash: true
					//			});
					
					
					
					//$.mobile.loadPage("#drivetracker");
					//$.mobile.changePage( $("#drivetracker"));
					
					//$.mobile.changePage("#drivetracker");
					//window.location.href = '#drivetracker';
                                        //var curquarter = drive.quarter;

			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);
		//$.mobile.changePage("#drivetracker");
			//console.log("target: "+target+" "+event.relatedTarget);
		});
	},
	
	driveChanged: function(event){
		var driveid = event.target.value;
		drivetracker.loadDrive(driveid);
	},
	setQuarter: function(quart){
		curQuart = quart;
		if (curQuart == 1)
		{
			var myButton = document.getElementById("buttonQT1");
			myButton.setAttribute("data-theme", "e");
			myButton.setAttribute("class", "ui-btn ui-btn-inner ui-btn-corner-all ui-shadow ui-btn-up-e");
		}
		else if (curQuart == 2)
		{
			var myButton = document.getElementById("buttonQT2");
			myButton.setAttribute("data-theme", "e");
			myButton.setAttribute("class", "ui-btn ui-btn-inner ui-btn-corner-all ui-shadow ui-btn-up-e");
		}
		else if (curQuart == 3)
		{
			var myButton = document.getElementById("buttonQT3");
			myButton.setAttribute("data-theme", "e");
			myButton.setAttribute("class", "ui-btn ui-btn-inner ui-btn-corner-all ui-shadow ui-btn-up-e");
		}
		else if (curQuart == 4)
		{
			var myButton = document.getElementById("buttonQT4");
			myButton.setAttribute("data-theme", "e");
			myButton.setAttribute("class", "ui-btn ui-btn-inner ui-btn-corner-all ui-shadow ui-btn-up-e");
		}
	},
	
	update: function(event){
		console.log("update");
		
		var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];
					var lastDrive = drives[drives.length-1];
					var lastDriveID = lastDrive.driveid;
					var lastDriveIndex = lastDrive.index;
					drivethis = lastDriveIndex -1;
					quarterthis = lastDrive.quarter;                //getQuarter!!!!
					drivetracker.loadDrive(lastDriveID, lastDriveIndex);
					drivetracker.loadDrives(lastDriveID);
					drivetracker.setQuarter(quarterthis);//HIGHTLIGHTS THE CURRENT QUARTER BUTTON
					
				}//sucess
			}//xhrArgs
			var deferred = $.ajax(xhrArgs);
	},
	
	updateR: function(event){
		history.go();
	},
	
	updatenext: function(event){
		console.log("updatenext");
		
		
		var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];
					
					var lastDrive = drives[drives.length-1];
					
					if (drivethis != lastDrive.index -1)
					{
						var nextdrive = drivethis + 1;
						drivethis = drivethis + 1;
					}
					var nextDrive = drives[nextdrive];
					var nextDriveID = nextDrive.driveid;
					var nextDriveIndex = nextDrive.index;
					quarterthis = nextDrive.quarter;
					drivetracker.loadDrive(nextDriveID, nextDriveIndex);
					drivetracker.loadDrives(nextDriveID);
					
				}//sucess
			}//xhrArgs
			
			var deferred = $.ajax(xhrArgs);
			
		//get the last driveid then loadDrives(lastid)
		//then loadDrive()
	},
	
	updateback: function(event){
		console.log("updatenext");
		
		if (drivethis != 0)
		{
			var backdrive = drivethis -1;
			drivethis = drivethis -1;
		}
		
		
		var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];
					var backDrive = drives[backdrive];
					var backDriveID = backDrive.driveid;
					var backDriveIndex = backDrive.index;
					quarterthis = backDrive.quarter;
					drivetracker.loadDrive(backDriveID, backDriveIndex);
					drivetracker.loadDrives(backDriveID);
					
				}//sucess
			}//xhrArgs
			var deferred = $.ajax(xhrArgs);
			
		//get the last driveid then loadDrives(lastid)
		//then loadDrive()
	},
	
	updatefirst: function(event){
		console.log("updatenext");
		
		var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];
					var check = 0;
					
					for(var i=drives.length-1;i>=0;i--){
						
						if (drives[i].quarter == quarterthis && check == 0)
						{
							var firstDrive=drives[i];
							check == 1;
						}
					}
					
					//var firstDrive = drives[0];
					var firstDriveID = firstDrive.driveid;
					var firstDriveIndex = firstDrive.index;
					
					drivethis = firstDriveIndex -1;
					
					drivetracker.loadDrive(firstDriveID, firstDriveIndex);
					drivetracker.loadDrives(firstDriveID);
					
				}//sucess
			}//xhrArgs
			var deferred = $.ajax(xhrArgs);
			
		//get the last driveid then loadDrives(lastid)
		//then loadDrive()
	},
	
	updatelast: function(event){
		console.log("updatenext");
		
		var xhrArgs = {
				url : server_name + "/service/get/drivetracker/getDrivesAll.php",
				contentType : "json",
				dataType: "json",
				data : {
					gameid : gameid
				},
				success : function(data) {
					var drives = data["drives"];
					var check = 0;
					var checkQ = quarterthis +1 ;
					
					for(var i=drives.length-1;i>=0;i--){
						
						if (quarterthis == 4)
						{
							var lastDrive = drives[drives.length-1];
							var lastDriveID = lastDrive.driveid;
							var lastDriveIndex = lastDrive.index;
							drivethis = lastDriveIndex -1;
							drivetracker.loadDrive(lastDriveID, lastDriveIndex);
							drivetracker.loadDrives(lastDriveID);
						}
						//already went down so cant see the quarter
						//quarterthis =3
						//checkQ = 4
						//i = 21 -> 0
						else
						{
							if (drives[i].quarter == quarterthis && check == 0)
							{
								
								check = 1;  // because you are loopin so you want only to get the last one; loop stopper
								//var j = i - 1;// def wrong
								var lastDrive = drives[i];
								var lastDriveID = lastDrive.driveid;
								var lastDriveIndex = lastDrive.index;
								drivethis = lastDriveIndex -1;
								drivetracker.loadDrive(lastDriveID, lastDriveIndex);
								drivetracker.loadDrives(lastDriveID);
							}
						}
					}
					
					
					
				}//sucess
			}//xhrArgs
			var deferred = $.ajax(xhrArgs);
			
		//get the last driveid then loadDrives(lastid)
		//then loadDrive()
	},
	
	loadDrive: function(driveid,driveidx){
		console.log("current quarter: "+currentQuarter);
		this.drive = driveid;
		this.driveidx = driveidx;
		$.ajax({
			url : server_name
					+ "/service/get/playbyplay/getPlaysByGameIdQuarter.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid,
				quarter : currentQuarter,
				driveid: driveid,
				driveidx: driveidx
			},
			success : function(data){
				try{
					console.log("parse plays");
				
					drivetracker.display.clear();
					for (var playdata in data){
						if (drivetracker.drive){
							console.log(data[playdata].drive+" =?= "+drivetracker.driveidx);
						}
						if (drivetracker.drive && data[playdata].drive!=drivetracker.driveidx){
							continue;
						}
						drivetracker.display.addPlay(data[playdata]);				
					}
					console.log("plays: "+drivetracker.display.plays.length);
					drivetracker.display.refresh();
				}catch(e){
					console.log(e);	
				}
			},
			error : function(jqXhr, error, thrown) {
			console.log("current quarter: "+currentQuarter);
			console.log("LoadDrive: An unexpected error occurred: " + error+" -- "+thrown);
			console.log("response: "+jqXhr.responseText);
                //for (var p in jqXhr){
                //    console.log(p);
                //}
			}
		}); //end of ajax
		
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getCurrent.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
				},
			success : function(data) {
				/*var imagesrc = unescape(data["image"]);
				var imageEle = $("#drvtrkr_img");
				imageEle.attr("src",imagesrc);
				imageEle.width = data["width"];
				imageEle.height = data["height"];
				*/
				var driveTitleEle = $("#drivetracker-drivename");
				//var driveTitleEleQT = $("#drivetracker-drivenameQT");
				driveTitleEle.html("Drive: "+data["homeaway"]+(data["driveindex"]?data["driveindex"]:""));
				//driveTitleEleQT.html("Drive: "+data["homeaway"]+(data["driveindex"]?data["driveindex"]:""));
				
				var updateEle = $("#drivetracker-update");
				if ("last15" in data && data["last15"]==true){
					updateEle.innerHTML="Update";	
				}
				else {
					updateEle.innerHTML="Live";	
				}
			},	
			error : function(error) {
				console.log("load drive image: An unexpected error occurred: " + error);
			}
		};// end of var xhrArgs
		
		
		if (driveid){
			xhrArgs.data["driveid"]=driveid;	
		}
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);
		
	}, //end of loadDrive
	loadDrives: function(curDrive){
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				
					var drives = data["drives"];
					var driveele = $("#drivetracker-drives");
					
					for(var i=drives.length-1;i>=0;i--){
						
						if (drives[i].driveid == curDrive)
						{
							var drive=drives[i];
						}
					}

					//var drive = drives[curDrive];
					var curquarter = drive.quarter;
					
					//pass in curDrive then
					//drive = drives[curDrive]
					//curquarter = drive.quarter
					
					console.log("load drives...");
					driveele.empty();
					driveele.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					driveele.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
					driveele.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
					driveele.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
					driveele.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
						.replace("driveid",drive.driveid)
						.replace(/index/g,drive.index)
						.replace("team",drive.homeaway)
						.replace("spotstart",drive.spotstart)
						.replace("spotend",drive.spotend)
						.replace("timestart",drive.timestart)
						.replace("timeended",drive.timeended)
						);
                //var selectEle = $("#drivetracker-drives");
				//"driveid":"1398","index":"1","quarter":"1","homeaway":"NCST","color":"#000000"
				//remove the current options so we dont have duplicates
					
					
				//while(selectEle.lastChild)
				//	selectEle.removeChild(selectEle.lastChild);
					//var curquarter=0;


					//for(var i=drives.length-1;i>=0;i--){
						//var drive=drives[i];
						//var opt;
						//if (curquarter!=drive["quarter"]){
							//curquarter = drive.quarter;
								
                        //Qtr	Spot	Time	Obtained	Spot	Time	How Lost
						//}
                    /*
                    driveid" => $d->getID(),
                            "index" => $driveindex,
                            "quarter" => $d->getStartQuarter(),
                            "homeaway" => $team,
                            "color" => $color,
                            "timestart" => $d->getStartTime(),
                            "obtained" => "",
                            "spotstart" => $d->getStartSpot(),
                            "spotend" => $d->getEndSpot(),
                            "timeended" => $d->getEndTime(),
                            "lost" => ""
                    */
                    //Qtr	Spot	Time	Obtained	Spot	Time	How Lost	Pl-Yds	TOP
						
						

                    //opt.html("<td>index</td><td>team</td>");
					//opt.setAttribute("value",drive["driveid"]);
					//selectEle.append(opt);
					//opt.innerHTML="Q"+drive["quarter"]+") "+
					//	drive["homeaway"]+drive["index"];
					//}
				//selectEle.trigger("change");
				//}catch(e){
					//console.log(e);
				//}
			}, //end sucess
			
			
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	
	}, //end loadDrives
	
	
	loadDrivesQT1: function()
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					//var driveele = $("#drivetracker-drives");
					
					var driveeleQT = $("#drivetracker-drivesQT1");
					
				
					console.log("load drives...");
                //var selectEle = $("#drivetracker-drives");
				//"driveid":"1398","index":"1","quarter":"1","homeaway":"NCST","color":"#000000"
				//remove the current options so we dont have duplicates
					//driveele.empty();
					driveeleQT.empty();
				//while(selectEle.lastChild)
				//	selectEle.removeChild(selectEle.lastChild);
					var curquarter=1; // Only get Quarter 1
					//driveele.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					
					//driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
					//driveeleQT.append("<tr><th>Test Get Quarter 1 Only</th></tr>");
					//driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
					//driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
                    //console.log("drive: "+drive.index+" team: "+drive.homeaway);
						if (curquarter ==drive["quarter"]){
                        //opt.html("<th>Quarter: "+drive["quarter"]+"</th>");
							//driveele.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							//curquarter = drive.quarter;
							//driveele.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
						
							//driveele.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
						
                        //Qtr	Spot	Time	Obtained	Spot	Time	How Lost
						
							driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
							.replace("driveid",drive.driveid)
							.replace(/index/g,drive.index)
							.replace("team",drive.homeaway)
							.replace("spotstart",drive.spotstart)
							.replace("spotend",drive.spotend)
							.replace("timestart",drive.timestart)
							.replace("timeended",drive.timeended)
							);
						}
                    /*
                    driveid" => $d->getID(),
                            "index" => $driveindex,
                            "quarter" => $d->getStartQuarter(),
                            "homeaway" => $team,
                            "color" => $color,
                            "timestart" => $d->getStartTime(),
                            "obtained" => "",
                            "spotstart" => $d->getStartSpot(),
                            "spotend" => $d->getEndSpot(),
                            "timeended" => $d->getEndTime(),
                            "lost" => ""
                    */
                    //Qtr	Spot	Time	Obtained	Spot	Time	How Lost	Pl-Yds	TOP
						//driveele.append(("<tr value='driveid' idx='index'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
						//.replace("driveid",drive.driveid)
						//.replace(/index/g,drive.index)
						//.replace("team",drive.homeaway)
						//.replace("spotstart",drive.spotstart)
						//.replace("spotend",drive.spotend)
						//.replace("timestart",drive.timestart)
						//.replace("timeended",drive.timeended)
						//);
						
						
                    //opt.html("<td>index</td><td>team</td>");
					//opt.setAttribute("value",drive["driveid"]);
					//selectEle.append(opt);
					//opt.innerHTML="Q"+drive["quarter"]+") "+
					//	drive["homeaway"]+drive["index"];
					}
				//selectEle.trigger("change");
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	
	},// end of loadDrivesQT
	
	loadDrivesQT1HL: function(curDriveID)
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					var driveeleQT = $("#drivetracker-drivesQT1");
					
					console.log("load drives...");
					driveeleQT.empty();

					var curquarter=1; // Only get Quarter 1

					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
						if (curquarter ==drive["quarter"]){
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							if (drive["driveid"] == curDriveID)
							{
								driveeleQT.append(("<tr value='driveid' idx='index' bgcolor='gold' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
							else
							{
								driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
						}
					}
				
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);
		
	},// end of loadDrivesQT1HIGHLIGHT
	
	loadDrivesQT2: function()
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					//var driveele = $("#drivetracker-drives");
					
					var driveeleQT = $("#drivetracker-drivesQT2");
					
				
					console.log("load drives...");
                //var selectEle = $("#drivetracker-drives");
				//"driveid":"1398","index":"1","quarter":"1","homeaway":"NCST","color":"#000000"
				//remove the current options so we dont have duplicates
					//driveele.empty();
					driveeleQT.empty();
				//while(selectEle.lastChild)
				//	selectEle.removeChild(selectEle.lastChild);
					var curquarter=2; // Only get Quarter 1
					//driveele.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					
					//driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
					//driveeleQT.append("<tr><th>Test Get Quarter 1 Only</th></tr>");
					//driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
					//driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
                    //console.log("drive: "+drive.index+" team: "+drive.homeaway);
						if (curquarter ==drive["quarter"]){
                        //opt.html("<th>Quarter: "+drive["quarter"]+"</th>");
							//driveele.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							//curquarter = drive.quarter;
							//driveele.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
						
							//driveele.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
						
                        //Qtr	Spot	Time	Obtained	Spot	Time	How Lost
						
							driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
							.replace("driveid",drive.driveid)
							.replace(/index/g,drive.index)
							.replace("team",drive.homeaway)
							.replace("spotstart",drive.spotstart)
							.replace("spotend",drive.spotend)
							.replace("timestart",drive.timestart)
							.replace("timeended",drive.timeended)
							);
						}
                    /*
                    driveid" => $d->getID(),
                            "index" => $driveindex,
                            "quarter" => $d->getStartQuarter(),
                            "homeaway" => $team,
                            "color" => $color,
                            "timestart" => $d->getStartTime(),
                            "obtained" => "",
                            "spotstart" => $d->getStartSpot(),
                            "spotend" => $d->getEndSpot(),
                            "timeended" => $d->getEndTime(),
                            "lost" => ""
                    */
                    //Qtr	Spot	Time	Obtained	Spot	Time	How Lost	Pl-Yds	TOP
						//driveele.append(("<tr value='driveid' idx='index'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
						//.replace("driveid",drive.driveid)
						//.replace(/index/g,drive.index)
						//.replace("team",drive.homeaway)
						//.replace("spotstart",drive.spotstart)
						//.replace("spotend",drive.spotend)
						//.replace("timestart",drive.timestart)
						//.replace("timeended",drive.timeended)
						//);
						
						
                    //opt.html("<td>index</td><td>team</td>");
					//opt.setAttribute("value",drive["driveid"]);
					//selectEle.append(opt);
					//opt.innerHTML="Q"+drive["quarter"]+") "+
					//	drive["homeaway"]+drive["index"];
					}
				//selectEle.trigger("change");
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	
	},// end of loadDrivesQT2
	
	loadDrivesQT2HL: function(curDriveID)
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					var driveeleQT = $("#drivetracker-drivesQT2");
					
					console.log("load drives...");
					driveeleQT.empty();

					var curquarter=2; // Only get Quarter 1

					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
						if (curquarter ==drive["quarter"]){
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							if (drive["driveid"] == curDriveID)
							{
								driveeleQT.append(("<tr value='driveid' idx='index' bgcolor='gold' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
							else
							{
								driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
						}
					}
				
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);
		
	},// end of loadDrivesQT2HIGHLIGHT
		
	loadDrivesQT3: function()
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					//var driveele = $("#drivetracker-drives");
					
					var driveeleQT = $("#drivetracker-drivesQT3");
					
				
					console.log("load drives...");
                //var selectEle = $("#drivetracker-drives");
				//"driveid":"1398","index":"1","quarter":"1","homeaway":"NCST","color":"#000000"
				//remove the current options so we dont have duplicates
					//driveele.empty();
					driveeleQT.empty();
				//while(selectEle.lastChild)
				//	selectEle.removeChild(selectEle.lastChild);
					var curquarter=3; // Only get Quarter 1
					//driveele.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					
					//driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
					//driveeleQT.append("<tr><th>Test Get Quarter 1 Only</th></tr>");
					//driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
					//driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
                    //console.log("drive: "+drive.index+" team: "+drive.homeaway);
						if (curquarter ==drive["quarter"]){
                        //opt.html("<th>Quarter: "+drive["quarter"]+"</th>");
							//driveele.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							//curquarter = drive.quarter;
							//driveele.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
						
							//driveele.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
						
                        //Qtr	Spot	Time	Obtained	Spot	Time	How Lost
						
							driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
							.replace("driveid",drive.driveid)
							.replace(/index/g,drive.index)
							.replace("team",drive.homeaway)
							.replace("spotstart",drive.spotstart)
							.replace("spotend",drive.spotend)
							.replace("timestart",drive.timestart)
							.replace("timeended",drive.timeended)
							);
						}
                    /*
                    driveid" => $d->getID(),
                            "index" => $driveindex,
                            "quarter" => $d->getStartQuarter(),
                            "homeaway" => $team,
                            "color" => $color,
                            "timestart" => $d->getStartTime(),
                            "obtained" => "",
                            "spotstart" => $d->getStartSpot(),
                            "spotend" => $d->getEndSpot(),
                            "timeended" => $d->getEndTime(),
                            "lost" => ""
                    */
                    //Qtr	Spot	Time	Obtained	Spot	Time	How Lost	Pl-Yds	TOP
						//driveele.append(("<tr value='driveid' idx='index'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
						//.replace("driveid",drive.driveid)
						//.replace(/index/g,drive.index)
						//.replace("team",drive.homeaway)
						//.replace("spotstart",drive.spotstart)
						//.replace("spotend",drive.spotend)
						//.replace("timestart",drive.timestart)
						//.replace("timeended",drive.timeended)
						//);
						
						
                    //opt.html("<td>index</td><td>team</td>");
					//opt.setAttribute("value",drive["driveid"]);
					//selectEle.append(opt);
					//opt.innerHTML="Q"+drive["quarter"]+") "+
					//	drive["homeaway"]+drive["index"];
					}
				//selectEle.trigger("change");
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	
	},// end of loadDrivesQT3
	
	loadDrivesQT3HL: function(curDriveID)
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					var driveeleQT = $("#drivetracker-drivesQT3");
					
					console.log("load drives...");
					driveeleQT.empty();

					var curquarter=3; // Only get Quarter 1

					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
						if (curquarter ==drive["quarter"]){
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							if (drive["driveid"] == curDriveID)
							{
								driveeleQT.append(("<tr value='driveid' idx='index' bgcolor='gold' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
							else
							{
								driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
						}
					}
				
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);
		
	},// end of loadDrivesQT3HIGHLIGHT
	
	
	loadDrivesQT4: function()
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					//var driveele = $("#drivetracker-drives");
					
					var driveeleQT = $("#drivetracker-drivesQT4");
					
				
					console.log("load drives...");
                //var selectEle = $("#drivetracker-drives");
				//"driveid":"1398","index":"1","quarter":"1","homeaway":"NCST","color":"#000000"
				//remove the current options so we dont have duplicates
					//driveele.empty();
					driveeleQT.empty();
				//while(selectEle.lastChild)
				//	selectEle.removeChild(selectEle.lastChild);
					var curquarter=4; // Only get Quarter 1
					//driveele.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					
					//driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
					//driveeleQT.append("<tr><th>Test Get Quarter 1 Only</th></tr>");
					//driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
					//driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
                    //console.log("drive: "+drive.index+" team: "+drive.homeaway);
						if (curquarter ==drive["quarter"]){
                        //opt.html("<th>Quarter: "+drive["quarter"]+"</th>");
							//driveele.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							//curquarter = drive.quarter;
							//driveele.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
						
							//driveele.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
						
                        //Qtr	Spot	Time	Obtained	Spot	Time	How Lost
						
							driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
							.replace("driveid",drive.driveid)
							.replace(/index/g,drive.index)
							.replace("team",drive.homeaway)
							.replace("spotstart",drive.spotstart)
							.replace("spotend",drive.spotend)
							.replace("timestart",drive.timestart)
							.replace("timeended",drive.timeended)
							);
						}
                    /*
                    driveid" => $d->getID(),
                            "index" => $driveindex,
                            "quarter" => $d->getStartQuarter(),
                            "homeaway" => $team,
                            "color" => $color,
                            "timestart" => $d->getStartTime(),
                            "obtained" => "",
                            "spotstart" => $d->getStartSpot(),
                            "spotend" => $d->getEndSpot(),
                            "timeended" => $d->getEndTime(),
                            "lost" => ""
                    */
                    //Qtr	Spot	Time	Obtained	Spot	Time	How Lost	Pl-Yds	TOP
						//driveele.append(("<tr value='driveid' idx='index'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
						//.replace("driveid",drive.driveid)
						//.replace(/index/g,drive.index)
						//.replace("team",drive.homeaway)
						//.replace("spotstart",drive.spotstart)
						//.replace("spotend",drive.spotend)
						//.replace("timestart",drive.timestart)
						//.replace("timeended",drive.timeended)
						//);
						
						
                    //opt.html("<td>index</td><td>team</td>");
					//opt.setAttribute("value",drive["driveid"]);
					//selectEle.append(opt);
					//opt.innerHTML="Q"+drive["quarter"]+") "+
					//	drive["homeaway"]+drive["index"];
					}
				//selectEle.trigger("change");
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);	
	},// end of loadDrivesQT4
	
	loadDrivesQT4HL: function(curDriveID)
	{
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getDrivesAll.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				try{
					var drives = data["drives"];
					var driveeleQT = $("#drivetracker-drivesQT4");
					
					console.log("load drives...");
					driveeleQT.empty();

					var curquarter=4; // Only get Quarter 1

					driveeleQT.append("<colgroup><col class='didx'/><col class='team'/><col/><col/><col/><col/></colgroup>");
					
					var count = 0;
					for(var i=drives.length-1;i>=0;i--){
						var drive=drives[i];
						var opt;
						
						if (curquarter ==drive["quarter"]){
							if (count == 0)
							{
								driveeleQT.append("<tr class='theading'><th colspan='6'>Quarter "+drive.quarter+"</th></tr>");
								driveeleQT.append("<tr><th colspan='2'></th><th colspan='2'>Start</th><th colspan='2'>End</th></tr>");
								driveeleQT.append(("<tr><th>Drive</th><th>Team</th>"+"<th>Spot</th><th>Time</th><th>Spot</th><th>Time</th>"+"</tr>"));
								count = 1;
							}
						
							if (drive["driveid"] == curDriveID)
							{
								driveeleQT.append(("<tr value='driveid' idx='index' bgcolor='gold' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
							else
							{
								driveeleQT.append(("<tr value='driveid' idx='index' align='center'><td>index</td><td>team</td>"+ "<td align='center'>spotstart</td><td align='center'>timestart</td><td align='center'>spotend</td><td align='center'>timeended</td>"+"</tr>")
								.replace("driveid",drive.driveid)
								.replace(/index/g,drive.index)
								.replace("team",drive.homeaway)
								.replace("spotstart",drive.spotstart)
								.replace("spotend",drive.spotend)
								.replace("timestart",drive.timestart)
								.replace("timeended",drive.timeended)
								);
							}
						}
					}
				
				}catch(e){
					console.log(e);
				}
			}, //end sucess
			error : function(jqXhr, error, thrown) {
				console.log("An unexpected error occurred: " + error+" -- "+thrown);
				for (var p in error){
					console.log(p);
				}
			}
		}; //end var xhrArgs
	
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);
		
	},// end of loadDrivesQT4HIGHLIGHT
	
	loadLegend: function(){
		var xhrArgs = {
			url : server_name + "/service/get/drivetracker/getLegend.php",
			contentType : "json",
			dataType: "json",
			data : {
				gameid : gameid
			},
			success : function(data) {
				var legendEle = $("#drivetracker-legend");
				var legend = data["legend"];
			},
			error : function(jqXHR,error) {
				console.log("An unexpected error occurred: " + error);
			}
		};
		// Call the asynchronous xhrGet
		var deferred = $.ajax(xhrArgs);
	} // end loadLegend
}// end of var drivtracer

function DriveTrackerDisplay(){
  this.canvas = document.getElementById("field_canvas");
  this.ctx = this.canvas.getContext("2d");
}
DriveTrackerDisplay.prototype = {
  plays: [],
  scale: 1.1,
  pwidth: 0,
  init: function(){
    //this.drawBackground();
    this.drawField();
    var self = this;
   
    var ctop = $(this.canvas).offset().top;
    $(this.canvas).bind("click touch touchend",function(event){
    	try{
    	var x = event.offsetX;
    	var y = event.offsetY;
    	if (!x || !y){
    	   var t = "";
    	   for (var p in event.originalEvent){
    	       t+=p+"="+event.originalEvent[p]+"\n";
    	   }
    	   //alert(t);
    	   //alert("touches: "+event.originalEvent.changedTouches.length);
    	   var touch = event.originalEvent.changedTouches.item(0);
    	   t = "";
    	   for (var p in touch){
    	       t+=p+"="+touch[p]+"\n";
    	   }
    	   //alert(t);
    	   x = touch.clientX;
    	   y = touch.clientY-ctop;  
    	}
    	//alert("touch x: "+x+" y: "+y+" x: "+event.clientX+" y: "+event.clientY);
    	}catch(e){
    	   //alert(e);  
    	}
    	self.click(x,y);
    	//console.log("click: x: "+x+" y: "+y+", offset: "+event.offsetX+","+event.offsetY+" screen: "+event.screenX+","+event.screenY+" layer: "+event.layerX+","+event.layerY+" page: "+event.pageX+","+event.pageY);	
    	
    });
  },
  drawBackground: function(){
    var ctx = this.ctx;
    var canvas = this.canvas;
    var bg = new Image();  
    bg.onload = function(){
      canvas.setAttribute("width",bg.width);
      canvas.setAttribute("height",bg.height);
      ctx.drawImage(bg,0,0);
    }  
    bg.src = "images/gameviz_autogen.png";
  },
  /*
  American football is played on a field 360 by 160 feet (120.0 by 53.3 yards;
  109.7 by 48.8 meters).[14] The longer boundary lines are sidelines, while the
  shorter boundary lines are end lines. Sidelines and end lines are out of
  bounds. Near each end of the field is a goal line; they are 100 yards (91.4
  m) apart. A scoring area called an end zone extends 10 yards (9.1 m) beyond
  each goal line to each end line. The end zone includes the goal line but not
  the end line.[14] While the playing field is effectively flat, it is common
  for a field to be built with a slight crownÑwith the middle of the field
  higher than the sidesÑto allow water to drain from the field.

  Yard lines cross the field every 5 yards (4.6 m), and are numbered every 10
  yards from each goal line to the 50-yard line, or midfield (similar to a
  typical rugby league field). Two rows of short lines, known as inbounds lines
  or hash marks, run at 1-yard (91.4 cm) intervals perpendicular to the
  sidelines near the middle of the field. All plays start with the ball on or
  between the hash marks. Because of the arrangement of the lines, the field is
  occasionally referred to as a gridiron.

  At the back of each end zone are two goalposts (also called uprights)
  connected by a crossbar 10 feet (3.05 m) from the ground. For high skill
  levels, the posts are 18 feet 6 inches (5.64 m) apart. For lower skill levels,
  these are widened to 23 feet 4 inches (7.11 m).
  */
  drawField: function(){
    var ctx = this.ctx;
    var canvas = this.canvas;
    //360 by 160
    var scale = this.scale;
    //var width = 160*scale;
    var width = this.width = 285*scale;
    var endzone = this.endzone = 30*scale;
    var height = this.height = 2*this.endzone+100*3.28*scale;
    this.lineScale = (this.height-endzone*2)/100;
    
    canvas.setAttribute("width",width);
    canvas.setAttribute("height",height);
    
    //First Endzone, GT
    ctx.fillStyle = home.color.dark;//"rgb(200,255,0)";
    ctx.fillRect (0, 0, width, endzone);
    
    //Second Endzone
    ctx.fillStyle = away.color.dark;//"rgb(200,255,0)";
    ctx.fillRect (0, height-endzone, width, endzone);
    
    //Field
    ctx.fillStyle = "rgb(0,90,0)";
    ctx.fillRect (0, endzone, width, height-2*endzone);
    
    //Draw lines
    ctx.fillStyle = "rgb(255,255,255)";
    for (var i=0;i<=100;i+=5){
      if (i%10==0 && i>0 && i<100){//Draw line numbers
        ctx.fillRect (0, endzone+((height-endzone*2)/100)*i, width, 1);
        ctx.fillText(""+(i>50?100-i:i),1, endzone+((height-endzone*2)/100)*i-2);
      } else if (i==0 || i==100){
        ctx.fillRect (0, endzone+((height-endzone*2)/100)*i, width, 1);
      }
    }
  },
  clear: function(){
  	this.drawField();
  	this.plays = [];	
    this.pwidth = 0;
  },
  addPlay: function(data){
  	var play = new Play(data, this);
  	if (this.plays.length<50){
        if (play.visible)
            this.pwidth+=play.width;
        if (this.pwidth<=this.width)
            this.plays.push(play);
  	}
  },
  click: function(x,y){
    try{
    var mindistance = 100000;
    var minplay;
    //alert("x: "+x+" y: "+y);
  	for (var i=0;i<this.plays.length;i++){
  		var play = this.plays[i];
  		if (play.visible){
            if (!play.box){
                console.log(i+" play has no box: "+play.text);
                continue;
            }
            
  			if (x>=play.box.x && x<=(play.box.x+play.box.width) &&
  					y>=play.box.y && y<=(play.box.y+play.box.height)){
  				
  				this.highlightPlay(play);
  				
  				mindistance=0;
  			    minplay = play;
  			       
  				return;			
  			} else {
  			   var distance = 10000;
  			   if (play.box){
      			   distance = Math.min(
      			       Math.sqrt((x-play.box.x)^2+(y*y-play.box.y*play.box.y)^2),
      			       Math.sqrt((x-play.box.x-play.box.width)^2+(y*y-play.box.y*play.box.y)^2),
      			       Math.sqrt((x-play.box.x)^2+(y*y-(play.box.y+play.box.height)*(play.box.y+play.box.height))^2),
      			       Math.sqrt((x-play.box.x-play.box.width)^2+(y*y-(play.box.y+play.box.height)*(play.box.y+play.box.height))^2)
      			   );
      			   //console.log("play: "+play.text);
      			   //console.log(Math.sqrt((x-play.box.x)^2+(y-play.box.y)^2));
      			   //console.log(Math.sqrt((x-play.box.x-play.box.width)^2+(y-play.box.y)^2));
      			   //console.log(Math.sqrt((x-play.box.x)^2+(y-play.box.y-play.box.height)^2));
      			   //console.log(Math.sqrt((x-play.box.x-play.box.width)^2+(y-play.box.y-play.box.height)^2));
      			   if (distance<mindistance && (x-play.box.x)/play.width < 3){
      			       mindistance=distance;
      			       minplay = play;   
      			   }
  			   } else {
                   console.log("no play box: "+i);
  			       console.log("no play box: "+play.text);
  			   }
  			}
  		}	
  	}
  	console.log("min play: "+mindistance+"\ntext: "+minplay.text);
  	//alert("min play: "+mindistance+"\ntext: "+minplay.text);
    }catch(e){
        console.log("err:"+e);   
    }
  },
  highlightPlay: function(play){
      var details = $("#drive-details");
      var playtxt = playsScript.parsePlayText(play.text);
      var id = playtxt[0];
      var detail = playtxt[1];

      console.log(play.text);
      
      $(details).find(".play-id").html(id);
      $(details).find(".play-detail").html(detail);
      
      if (play.video){
          $(details).find(".play-vid-preview").show();
          $(details).find(".play-vid-preview a").attr("href",play.video);
          $(details).find(".play-vid-preview img").attr("src",play.videoPreview);
          
          $("#drive-details #view-video").show();
      } else {
          $(details).find(".play-vid-preview").hide(); 
          $("#drive-details #view-video").hide();
      }      
      details.removeClass("hidden");
      
      details.css({"bottom": 0, "left": 0, "right": 0, "width":$("#drivetracker").width()+"px"});
      
      this.highlight = play;
  },
  highlightPrevious: function(){
      if (this.highlight){
        for (var i=0;i<this.plays.length-1;i++){
            if (this.plays[i]==this.highlight){
                this.highlightPlay(this.plays[i+1]);  
                break;
            }
        } 
      }
  },
  highlightNext: function(){
      if (this.highlight){
        for (var i=0;i<this.plays.length;i++){
            if (this.plays[i]==this.highlight){
                if (i>0){
                    this.highlightPlay(this.plays[i-1]);  
                    break;
                }
            }
        } 
      }
  },
  drawDrive: function(color,team, width, offset){
    //console.log("drawdrive: "+offset+" "+width+" "+color);
    var ctx = this.canvas.getContext("2d");
    rgbc = hexToRGB(color);
    rgbac = "rgba("+(rgbc[0]+50)+","+(rgbc[1]+50)+","+(rgbc[2]+50)+",.5)";
    
    ctx.fillStyle=rgbac;
    
    var x=this.width-offset-width;
    var y=this.endzone+1;
    var height=(this.height-2*this.endzone)-1;
    if (team==away.acrynm){
        var arrowy = y+height-width/2;
        if (arrowy<=y){
            arrowy=y;
            height=0;
        } else {
            height=height-width/2;
            arrowy-=.5; height+=.5;
        }
        
        ctx.beginPath();
        ctx.moveTo(x,arrowy);
        ctx.lineTo(x+width,arrowy);
        ctx.lineTo(x+width/2,arrowy+width/2);
        ctx.fill();
        
    } else {
        var arrowy = y;
        height=height-width/2;
        if (height<0){
            arrowy=y-width/2;
            height=0;
        } else {
            y=y+width/2;
            //height+=.5;
        }
        
        ctx.beginPath();
        ctx.moveTo(x,arrowy+width/2);
        ctx.lineTo(x+width,arrowy+width/2);
        ctx.lineTo(x+width/2,arrowy);
        ctx.fill();
    }
    
    ctx.fillRect(x,y,width,height);
  },
  refresh: function(){
    this.offset = (this.width-this.pwidth)/2;
    if (this.offset<0) this.offset=0;
    
    var dwidth=0, drive = -1, team="H", color=0;
    var offset = this.offset;
    for (var i=0;i<this.plays.length;i++){
        var play = this.plays[i];
        if (play.data.drive==drive){
            if (play.visible)
                dwidth+=play.width;
        } else {
            
            if (drive!=-1){
                this.drawDrive(color,team, dwidth, offset);
            }
            offset+=dwidth;          
            drive=play.data.drive;
            //console.log("drive: "+drive);
            if (play.homeHasBall()){
                team = home.acrynm;
                color = home.color.dark;
            } else {
                team = away.acrynm;
                color = away.color.dark;
            }
            dwidth=0;
            if (play.visible)
                dwidth+=play.width;
        }
    }
    if (drive!=-1){
        this.drawDrive(color,team, dwidth, offset);
    }
    
    this.drawDownMarkers();
  	var count=0;
    
    //console.log("offset: "+this.offset+" "+this.pwidth);
  	for (var i = 0;i<this.plays.length && count<25;i++){
  		if (this.plays[i].draw(this.canvas, count, this.offset)){
  			count++;	
  		} else {
  			this.plays.splice(i,1);
  			i--;	
  		}
  	}
  },
  drawDownMarkers: function(){
    var ctx = this.canvas.getContext("2d");
  	//Draw first down & line of scrimmage
  	var lastplay = this.plays[0];
  	ctx.strokeStyle="rgb(250,250,100)";
  	ctx.lineWidth=2;
  	ctx.beginPath();
  	ctx.moveTo(15,lastplay.getPixelVal(lastplay.firstdown));
  	ctx.lineTo(this.width,lastplay.getPixelVal(lastplay.firstdown));
  	ctx.closePath();
  	ctx.stroke();
  	
  	var scrimmage=lastplay.end==-1?lastplay.start:lastplay.end;
  	ctx.strokeStyle="rgb(0,0,250)";
  	ctx.lineWidth=2;
  	ctx.beginPath();
  	ctx.moveTo(15,lastplay.getPixelVal(scrimmage));
  	ctx.lineTo(this.width,lastplay.getPixelVal(scrimmage));
  	ctx.closePath();
  	ctx.stroke(); 
  }
}
function Drive(){

}
Drive.prototype = {
	
}
function Play(data, field){
	this.data = data;	
	this.field = field;
	
	
	//V05 and V03 works; V5 and V03 doesnt work
	//this.start = this.get100YardVersionEugene(this.getStartEugene("MT05"));           
	//this.end = this.get100YardVersionEugene(this.getStartEugene("MT3"));
	
	this.start = this.get100YardVersionEugene(data.spot);           //1) v05 to v1 fails; 2) v5 to v1 works; 3) v05 to v01 works; 4) v5 to v01 works
	this.end = this.get100YardVersionEugene(this.getEndSpotEugene(data.text));               // data.spot = spot="MT05" 
	                                                                                      // text="Laskey, Z. rush for 4 yards to the MT1 (Antoine, A.)." 
	//this.start = this.get100YardVersionEugene("V25");                                   //case 1; need case 3
												//MT1 works MT01 works
	//this.end = this.get100YardVersionEugene("V09");
	
	//this.start =  25;          
	//this.end = 9;
	
	this.ball = data.ball;
	if (this.ball=="H"){
		this.firstdown = this.start-data.togo;
	} else {
		this.firstdown = this.start+data.togo	
	}
	this.type = data.type;
	
	if (this.data['videos']){
    	this.video = '/videos/'
    	                + data['videos']['0'].path
    					+ 'small_mp4/'
    					+ data['videos']['0'].filename
    					+ '.mp4';
    	this.videoPreview = this.video.replace(/\.mp4/,".jpg");
	}
    
    this.process();
    
	console.log("play: "+data.spot+", ball: "+data.ball+" togo: "+data.togo+" drive: "+data.drive+" type: "+data.type);
}


Play.prototype = {
	width: 15,
	get text()
	{
		return this.data.text;	
	},
	start: -1,
	end: -1,
	firstdown: -1,
	type: "",
	box: null,
	visible: false,
	score: 0,
	process: function(){			
		if (this.isDriveStart() || this.isTimeout())
		{
			return 0;	
		}
		
		if (this.isFieldGoal()
                || this.isExtraPoint() 
                || this.isPenalty()
                || this.isPunt()
                || this.isKickoff()
                || this.isFumble()
                || this.isIntercept()
                || this.isSack()
                || this.isPass()
                || this.isRush()
		){
			this.visible = true;
			return 1;
		}
		return 0;
	},
	draw: function(canvas, index, offset)
	{
		var ctx = canvas.getContext("2d");
		var x = parseInt(canvas.getAttribute("width"))-(index+1)*this.width-offset;
		if (x < 15)
		{
			this.visible = false;
			return 0;
		}		
		if (this.isDriveStart() || this.isTimeout())
		{
			this.visible = false;
			return 0;	
		}
		if (this.isTouchdown())
		{
			this.drawTouchdown(ctx, x, this.start);
			this.score=6;
			if (this.isExtraPoint())
			{
				this.score+=1;
			}
			else if (false)
			{
				this.score+=2;
			}
		} 
		if (this.isFieldGoal() || this.isExtraPoint())
		{
			if(this.isFieldGoal())
			{
				this.drawFG(ctx,x);
				this.visible = true;
				return 1;
			}
			else
			{
				this.drawKick(ctx,x);
				this.visible = true;
				return 1;
			}
		}
		if (this.isPenalty()){
			if(this.isDeclined())
			{
				if(this.isPass())
				{
					if (this.isIncomplete())
					{
						this.drawIncomplete(ctx, x);
						this.visible = true;
					}
					else if (this.isIntercept())
					{
						console.log("interception");
						ctx.fillStyle = "rgb(255,100,0)";
						this.drawArrow(ctx, x, true);
						this.visible = true;
					}
					else
					{
						ctx.fillStyle = "rgb(250,0,0)";
						this.drawArrow(ctx, x);
						this.visible = true;
					}
				}
				else if (this.isRush())
				{
					console.log("draw rush from "+this.start+" to "+this.end);
					ctx.fillStyle = "rgb(0,0,250)";
					this.drawArrow(ctx, x);
				}
				
				return 1;
			}
			else if(this.isOffset())         //maybe some graphics for OFFSET
			{
				this.visible = false;
				return 1;
			}
			else if(this.isPunt() || this.isKickoff())
			{
				console.log("is punt");
				ctx.fillStyle="rgb(0,0,0)";
				this.drawArrow(ctx,x); 
				this.visible = true;
				return 1;
			}
			else
			{
				ctx.fillStyle = "rgb(250,250,100)";
				this.drawArrow(ctx, x);
				this.visible = true;
				return 1;
			}
		}
		if (this.isPunt() || this.isKickoff())
		{
		    console.log("is punt");
		    ctx.fillStyle="rgb(0,0,0)";
		    this.drawArrow(ctx,x); 
		    this.visible = true;
		    return 1;
		}
		if (this.isFumble())
		{
			if (this.isFumbleLost())
			{
				console.log("lost fumble");
			} else
			{
				console.log("fumble");	
			}
			ctx.fillStyle = "rgb(255,100,0)";
			this.drawArrow(ctx,x);
		}
		else if (this.isSack())
		{
			console.log("is sack");
			ctx.fillStyle = "rgb(0,0,250)";
			this.drawArrow(ctx, x, true);
		}
		else if (this.isPass())
		{
			if (this.isIncomplete())
			{
				this.drawIncomplete(ctx, x);
			}
			else if (this.isIntercept())
			{
				console.log("interception");
				ctx.fillStyle = "rgb(255,100,0)";
				this.drawArrow(ctx, x, true);
			}
			else
			{
				ctx.fillStyle = "rgb(250,0,0)";
				this.drawArrow(ctx, x);
			}
		}
		else if (this.isRush())
		{
			console.log("draw rush from "+this.start+" to "+this.end);
			ctx.fillStyle = "rgb(0,0,250)";
			this.drawArrow(ctx, x);
		}
		else
		{
			return 0;	
		}
		this.visible = true;
		return 1;
	},
	drawKick: function(ctx, x)
	{
	   this.drawGoalPosts(ctx, x, this.start);
	   if (this.isMissed() || this.isBlocked())
	   {
	       console.log("kick missed or blocked");
	       ctx.strokeStyle="rgb(250,0,0)";
	       ctx.lineWidth=3;
	       ctx.fillStyle="rgb(250,0,0)";
	       ctx.beginPath();
		ctx.moveTo(x+2*this.field.scale,this.getPixelVal(this.start)-this.width*3/2)
		ctx.lineTo(x+this.width-2*this.field.scale,this.getPixelVal(this.start)-this.width/2-2*this.field.scale);
		ctx.closePath();
		ctx.stroke();
           
		ctx.beginPath();
		ctx.moveTo(x+this.width-2*this.field.scale,this.getPixelVal(this.start)-this.width*3/2)
		ctx.lineTo(x+2*this.field.scale,this.getPixelVal(this.start)-this.width/2-2*this.field.scale);
		ctx.closePath();
		ctx.stroke();
           
		this.box = new Rect(x,this.getPixelVal(this.start)-this.width*3/2,this.width,this.width*2);
	   }
	   else
	   {
	       //draw plus one
	       ctx.fillStyle="#FFFFFF";
	       ctx.fillText("+1",x+3,this.getPixelVal(this.start)+this.width/2);    
	       this.box = new Rect(x,this.getPixelVal(this.start)-this.width*3/2,this.width,this.width*2);   
	   }
	},
	drawFG: function(ctx, x) //Eugene 15OCT
	{
		this.drawGoalPosts(ctx, x, this.start);
		if (this.isMissed() || this.isBlocked())
		{
	       console.log("kick missed or blocked");
	       ctx.strokeStyle="rgb(250,0,0)";
	       ctx.lineWidth=3;
	       ctx.fillStyle="rgb(250,0,0)";
	       ctx.beginPath();
		ctx.moveTo(x+2*this.field.scale,this.getPixelVal(this.start)-this.width*3/2)
		ctx.lineTo(x+this.width-2*this.field.scale,this.getPixelVal(this.start)-this.width/2-2*this.field.scale);
		ctx.closePath();
		ctx.stroke();
           
		ctx.beginPath();
		ctx.moveTo(x+this.width-2*this.field.scale,this.getPixelVal(this.start)-this.width*3/2)
		ctx.lineTo(x+2*this.field.scale,this.getPixelVal(this.start)-this.width/2-2*this.field.scale);
		ctx.closePath();
		ctx.stroke();
           
		this.box = new Rect(x,this.getPixelVal(this.start)-this.width*3/2,this.width,this.width*2);
		}
		else
		{
			//draw plus one
			ctx.fillStyle="#FFFFFF";
			ctx.fillText("+3",x+3,this.getPixelVal(this.start)+this.width/2);    
			this.box = new Rect(x,this.getPixelVal(this.start)-this.width*3/2,this.width,this.width*2);   
		}
	},
	drawGoalPosts: function(ctx, x, y)
	{
	   var height = this.width*2;
	   ctx.fillStyle="rgb(250,250,100)";
	   //Left post
	   ctx.fillRect(x,this.getPixelVal(this.start)-this.width*3/2, 2*this.field.scale,
	       this.width);
	   //Right post
	   ctx.fillRect(x+this.width-2*this.field.scale,this.getPixelVal(this.start)-this.width*3/2, 2*this.field.scale,
	       this.width);
	   //Middle post
	   ctx.fillRect(x+this.width/2-1*this.field.scale,this.getPixelVal(this.start)-this.width/2, 2*this.field.scale,
	       this.width*1/2);
	   //Horizontal post
	   ctx.fillRect(x,this.getPixelVal(this.start)-this.width/2-2*this.field.scale, this.width,
	       2*this.field.scale);
	},
	/*
	* Name of Function: drawTouchdown
	* Purpose of Method: To display touchdown text onto our football canvas on the driver tracker page.
	* Creater of the Method: Eugene Park. epark60@gatech.edu
	* Editors: <Enter your name, email, and optionally phone number if you are 
	* 			the person who edited this method, ALSO enter the date and time
	* 			the change was made>
	*/
	drawTouchdown: function(ctx, x, y)
	{
		//ctx.shadowOffsetX = 1;
		//ctx.shadowOffsetY = 1;
		//ctx.shadowBlur = 1;
		//ctx.shadowColor = "rgba(0, 0, 0, 0.5)";
		//ctx.font = "15px Times New Roman";
		//ctx.fillStyle = "Black";
		
		ctx.strokeStyle = "#ffffff";
                ctx.font = '20px Times New Roman';
                ctx.textBaseline = 'bottom';
		
		
		if (this.homeHasBall())
		{
			ctx.fillText("TOUCHDOWN "+homeacrynm+"!", 80, 20);
		}
		else
		{
			ctx.fillText("TOUCHDOWN "+awayacrynm+"!", 75, 420);
		}
	},
	drawIncomplete: function(ctx, x)
	{
		ctx.fillStyle="#FF0000";
		ctx.beginPath();
		ctx.arc(x+this.width/2,this.getPixelVal(this.getYs()[0]),
			this.width/2,0,Math.PI*2,true);
		ctx.closePath();
		ctx.fill();
		
		ctx.fillStyle="#FFFFFF";
		ctx.fillRect(x+2,this.getPixelVal(this.getYs()[0])-this.width/10, this.width-4, this.width/5);
		
		this.box = new Rect(x,this.getPixelVal(this.getYs()[0])-this.width/2,
		                    this.width,this.width);
	},
	drawArrow: function(ctx, x, reverse)
	{		
		var y;
		var height;
		var aheight = Math.floor(this.width/2);
		
		if (this.start==this.end)
		{
			if (this.homeHasBall() && !reverse)
			{
				this.end=parseInt(this.start)-1;
			}
			else
			{
				this.end=parseInt(this.start)+1;
			}
		}
	       
		if (this.start < this.end)
		{
			y = this.field.endzone + this.start*this.field.lineScale;
			height = (this.end - this.start)*this.field.lineScale;
			var arrowy = y+height-aheight;
			
			if (arrowy<=y)
			{
				arrowy=y;
				height=0;
			}
			else
			{
				height=height-aheight;
				arrowy-=.5;
				height+=.5
				if (height<0)
					height=0;
			}
            
			ctx.beginPath();
			ctx.moveTo(x,arrowy);
			ctx.lineTo(x+this.width,arrowy);
			ctx.lineTo(x+aheight,arrowy+aheight);
			ctx.fill();
			
			this.box = new Rect(x,y,this.width,y+height+aheight);
		}
		else if (this.start > this.end)
		{
			y = this.field.endzone + this.end*this.field.lineScale;
			height = (this.start - this.end)*this.field.lineScale;
			
			var arrowy = y;
			height=height-aheight;
			
			if (height<0)
			{
				arrowy=y-aheight;
				height=0;
			}
			else
			{
				y=y+aheight-.5;
			}
		          
			ctx.beginPath();
			ctx.moveTo(x,arrowy+aheight);
			ctx.lineTo(x+this.width,arrowy+aheight);
			ctx.lineTo(x+aheight,arrowy);
			ctx.fill();
		          
			this.box = new Rect(x,arrowy,this.width,height+aheight);
		}
        
		if (height>0)
		{
			ctx.fillRect(x,y,this.width,height);
		}
	},
	drawArrow2: function(ctx, x, reverse)
	{		
		var y, height;
		var aheight = Math.floor(this.width/2);
		
		if (this.start==this.end)
		{
			if (this.homeHasBall() && !reverse)
			{
				this.end=parseInt(this.start)-1;
			}
			else
			{
				this.end=parseInt(this.start)+1;
			}
		}
	       
		if (this.start < this.end)
		{
			y = this.field.endzone + this.start*this.field.lineScale;
			height = (this.end - this.start)*this.field.lineScale;
			var arrowy = y+height-aheight;
			
			if (arrowy<=y)
			{
				arrowy=y;
				height=0;
			}
			else
			{
				height=height-aheight;
				arrowy-=.5;
				height+=.5
				if (height<0)
					height=0;
			}
            
			ctx.beginPath();
			ctx.moveTo(x,arrowy);
			ctx.lineTo(x+this.width,arrowy);
			ctx.lineTo(x+aheight,arrowy+aheight);
			ctx.fill();
			
			this.box = new Rect(x,y,this.width,y+height+aheight);
		}
		else if (this.start > this.end)
		{
			y = this.field.endzone + this.end*this.field.lineScale;
			height = (this.start - this.end)*this.field.lineScale;
			
			var arrowy = y;
			height=height-aheight;
			
			if (height<0)
			{
				arrowy=y-aheight;
				height=0;
			}
			else
			{
				y=y+aheight-.5;
			}
            
			ctx.beginPath();
			ctx.moveTo(x,arrowy+aheight);
			ctx.lineTo(x+this.width,arrowy+aheight);
			ctx.lineTo(x+aheight,arrowy);
			ctx.fill();
            
			this.box = new Rect(x,arrowy,this.width,height+aheight);
		}
        
		if (height>0)
		{
			ctx.fillRect(x,y,this.width,height);
		}
	},
	getPixelVal: function(footballval)
	{
	   return this.field.lineScale*footballval+this.field.endzone;   
	},
	// Assumes spot is like H25 or V14
	get100YardVersion: function(spot)
	{
		if (spot==-1)
			return -1;
		var matches = spot.match(/^([HV])([0-9]{1,2})$/);
		if (!matches)
			return -1;
		
		var team = matches[1];
		var yard = matches[2];
		if (team == "H")
		{
			return 100-yard;
		}
		else //V
		{
			return yard;
		}
	},
	get100YardVersionEugene: function(spot)
	{
		if (spot==-1)
			return "1";
		
		var matches = spot.match(/^([HV])([0-9]{1,2})$/);
		if (!matches) return -1;
		
		var team = spot.match(/H|V/);
		var yard = spot.match(/[0-9]+/);
		

		if (team && team[0] == "H")
		{
			return 100-(yard && yard[0] || 0);
		}
		else //V
		{
			return yard && yard[0];
		}
	},
	//returns Y vals in array from lowest # to highest #
	getYs: function()
	{
		//if (this.end==-1)
		//	return [this.start,this.start];	   
		//if (this.start>this.end)
		//{
		//	return [this.end,this.start];
		//}
		//else
		//	return [this.start, this.end];
		//	
			
		return [this.start,this.start];	   
	},
	getEndSpot: function()
	{
		//homeacrynm,awayacrynm
		var regex = new RegExp("to the +("+homeacrynm+"|"+awayacrynm+")?([0-9]{1,2})","g");
		var matches = this.text.match(regex);
		if (matches)
		{
			pos = matches[matches.length-1]
			matches = pos.match(/to the ([A-Z]+)?([0-9]{1,2})/);
			if (!matches[1])
			{
				matches=[pos,"V",50];	
			}
		}
		else
		{
			return -1;	
		}
		var acr = matches[1];
		var yard = matches[2];
		if (acr == homeacrynm) 
			return "H"+yard;
		else
			return "V"+yard;
	},
	getEndSpotEugene: function(spot)  //to the GT35
	{
		var regex = new RegExp("to the +("+homeacrynm+"|"+awayacrynm+")?([0-9]{1,2})","g");
		var matches = this.text.match(regex);
		if (matches)
		{
			pos = matches[matches.length-1]
			matches = pos.match(/to the ([A-Z]+)?([0-9]{1,2})/);
			if (!matches[1])
			{
				matches=[pos,"V",50];	
			}
		}
		else
		{
			return -1;	
		}
		var acr = matches[1];
		var yard = matches[2];
		
		var yardCheck = parseInt(yard, 10);
		
		if (acr == homeacrynm)
		{
			if(yardCheck < 10)
			{
				return "H0"+yard;
			}
			else
				return "H"+yard;
		}
		else
		{
			if(yardCheck < 10)
			{
				return "V0"+yard;
			}
			else
				return "V"+yard;
		}
	},
	getStartSpot: function(spot)  //ex: GT01 or maybe H01
	{
		var acr = spot.match(/[A-Z]+/);
		var yard = spot.match(/[0-9]+/);
		
		var yardCheck = parseInt(yard);

		if (acr == homeacrynm ||acr == "H")
		{
			return "H"+yard;
		}
		else if (acr == awayacrynm || acr == "V")
		{
			return "H"+yard;
		}
		else
			return "V01";  //error check cases
	},
	getStartEugene: function(spot)  //ex: GT01 GT1
	{
		var team = "blah";
		team = spot.match(/GT/);             //look for GT and if its no then we know that it's away
		var yard = spot.match(/[0-9]+/);

		var yardCheck = parseInt(yard, 10);
		
		if (team && team[0] == "GT")
		{
			if(yardCheck < 10)
			{
				return "H0"+yard;
			}
			else
				return "H"+yard;
		}
		else //V
		{
			if(yardCheck < 10)
			{
				return "V0"+yard;
			}
			else
				return "V"+yard;
		}
	},
	isFumbleLost: function()
	{
		var matches = this.text.match(new RegExp("recovered by ("+awayacrynm+"|"+homeacrynm+")","g"));
		if (!matches)
			return false;
		
		var last = matches[matches.length-1];
		
		if (this.getHasBall()=="H")
		{
			return last.indexOf(awayacrynm)>0;
		}
		else
		{
			return last.indexOf(homeacrynm)>0;
		}
		
		return false;	
	},
	isTimeout: function()	   { return  this.text.match(/timeout/i); },
	isSack: function()	   { return  this.text.match(/sacked/i); },
	isDriveStart: function()   { return  this.text.match(/drive start/i); },
	isIncomplete: function()   { return  this.text.match(/incomplete/i); },
	isTouchdown: function()    { return  this.text.match(/TOUCHDOWN/i); },
	isIntercept: function()    { return  this.text.match(/intercept/i); },
	isDeclined: function()     { return  this.text.match(/declined/i); },
	isOffset: function()       { return  this.text.match(/off-setting/i); },
	isMissed: function()       { return  this.text.match(/MISSED/i); },
	isBlocked: function()      { return  this.text.match(/BLOCKED/i); },
	isFailed: function()       { return  this.text.match(/failed/i); },
	isFumble: function()       { return  this.text.match(/FUMBLE/i); },
	isPenalty: function()      { return (this.text.match(/PENALTY/i) || this.type=="E"); },
	isPass: function()         { return (this.text.match(/pass/i) || this.type == "P"); },
	isRush: function()         { return (this.type == "R"); },
	isFieldGoal: function()    { return (this.type == "F"); },
	isExtraPoint: function()   { return (this.type == "X"); },
	isPunt: function()         { return (this.type == "U"); },
	isKickoff: function()      { return (this.type == "K"); },
	visitorHasBall: function() { return (this.getHasBall() == "V"); },
	homeHasBall: function()    { return (this.getHasBall() == "H"); },
	isUndrawable: function()   { return (this.type == "K" || this.type == "#" || !this.text || this.text==""); }, 
	getHasBall: function(){
    	return this.ball;
    }
}

function Rect(x,y,width,height){
	this.x=x; this.y=y;
	this.width=width; this.height=height;	
}

function hexToRGB(h) {
   h= (h.charAt(0)=="#") ? h.substring(1,7):h;
   return [
    parseInt(h.substring(0,2),16),
    parseInt(h.substring(2,4),16),
    parseInt(h.substring(4,6),16)
   ];
}