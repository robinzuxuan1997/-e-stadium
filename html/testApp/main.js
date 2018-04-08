//change this variable to the server used
//var server_name = 'http://estaddev.vip.gatech.edu';

// global variables
var gameId, homeId, homeName, homeAcronym, homeLogoPath, visitorId, visitorName, visitorAcronym, visitorLogoPath;
var homeTotal, home1Q, home2Q, home3Q, home4Q, homeOQ, homeHasBall;
var visitorTotal, visitor1Q, visitor2Q, visitor3Q, visitor4Q, visitorOQ, visitorHasBall;
var gameTime, gametStatusText;
var currentQuarter;

var viewsStatus = {
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
	}
};

var states = {};

function loader() {
	
	// Load the basic mobile widgetry and support code.
	dojo.require("dojox.mobile");

	// Load the lightweight parser. dojo.parser can also be used, but it
	// requires much more code to be loaded.
	dojo.require("dojox.mobile.parser");

	// Load the compat layer if the incoming browser isn't webkit based
	dojo.requireIf(!dojo.isWebKit, "dojox.mobile.compat");

	dojo.require("dojo.io.script");
	
	dojo.require("dojo.hash");
	dojo.addOnLoad(callback);
}

function callback() {
	
	getGameGeneralInfo(callback2);
	
	//dojo.back.setInitialState(states["home"]);
	dojo.subscribe("/dojo/hashchange", null, onHashChangeCallback);
	//Initialize the first page, this won't get a change callback
	onHashChangeCallback(dojo.hash());
}

function callback2() {
	getGameScoreBoardData();
	getGameStatus();
}

//Support back/forward
function onHashChangeCallback(value){
	if (value in states){
		states[value].handle();	
	}
}

dojo.config.parseOnLoad = true;
dojo.addOnLoad(loader);
