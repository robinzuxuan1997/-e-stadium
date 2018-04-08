states["drivetracker"]={
	handle: function(){
		loadDriveTrackerView();
		//alert("Drive Tracker!");	
	}
}

function loadDriveTrackerView() {
	if ((viewsStatus.drivetracker.time + 30000) < new Date().getTime()) {
		drivetracker.loadDrive();
		drivetracker.loadDrives();
		//if (viewsStatus.drivetracker.time == 0)	
		//	loadDriveTrackerLegend();	
		viewsStatus.drivetracker.time = new Date().getTime();	
	}
	//dojo.hash("drivetracker");
	//dojo.back.addToHistory(states["drivetracker"]);
}

var drivetracker = {
	driveChanged: function(event){
		var driveid = event.target.value;
		drivetracker.loadDrive(driveid);
	},
	update: function(event){
		drivetracker.loadDrive();
	},
	loadDrive: function(driveid){
		var xhrArgs = {
			url : server_name
					+ "/service/get/drivetracker/getCurrent.php",
			handleAs : "json",
			content : {
				gameid : gameId
			},
			load : function(data) {
				var imagesrc = unescape(data["image"]);
				var imageEle = dojo.byId("drvtrkr_img");
				imageEle.setAttribute("src",imagesrc);
				imageEle.width = data["width"];
				imageEle.height = data["height"];
				
				var driveTitleEle = dojo.byId("drivetracker-drivename");
				driveTitleEle.innerHTML = "Drive: "+data["homeaway"]+(data["driveindex"]?data["driveindex"]:"");
				
				var updateEle = dojo.byId("drivetracker-update");
				if ("last15" in data && data["last15"]==true){
					updateEle.innerHTML="Update";	
				} else {
					updateEle.innerHTML="Live";	
				}
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};
		if (driveid){
			xhrArgs.content["driveid"]=driveid;	
		}
		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
	},
	loadDrives: function(){
		var xhrArgs = {
			url : server_name
					+ "/service/get/drivetracker/getDrivesAll.php",
			handleAs : "json",
			content : {
				gameid : gameId
			},
			load : function(data) {
				var drives = data["drives"];
				var selectEle = dojo.byId("drivetracker-drives");
				//"driveid":"1398","index":"1","quarter":"1","homeaway":"NCST","color":"#000000"
				//remove the current options so we dont have duplicates
				while(selectEle.lastChild)
					selectEle.removeChild(selectEle.lastChild);
				for(var i=drives.length-1;i>=0;i--){
					var drive=drives[i];
					var opt = document.createElement("option");
					
					opt.setAttribute("value",drive["driveid"]);
					selectEle.appendChild(opt);
					opt.innerHTML="Q"+drive["quarter"]+") "+
						drive["homeaway"]+drive["index"];
				}
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};
	
		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);	
	},
	loadLegend: function(){
		var xhrArgs = {
			url : server_name
					+ "/service/get/drivetracker/getLegend.php",
			handleAs : "json",
			content : {
				gameid : gameId
			},
			load : function(data) {
				var legendEle = dojo.byId("drivetracker-legend");
				var legend = data["legend"];
			},
			error : function(error) {
				console.log("An unexpected error occurred: " + error);
			}
		};
	
		// Call the asynchronous xhrGet
		var deferred = dojo.xhrGet(xhrArgs);
	}
}
