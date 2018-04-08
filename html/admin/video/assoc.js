var quarter = "Q1";
var mode = "new";
function init(){
	console.log("init");
	get();
	
	$("#assoc-existing-header").click(toggleExisting);
	$("#assoc-new-header").click(toggleNew);
}
function get(data,clear){
	var postdata = {
	  url: 'service.php',
	  timeout: 6000,
	  dataType: "json",
	  success: function(data, status){
	  	console.log("Success!: "+status);
	  	if (clear)
	  		clearTable(mode);
	  	processData(data);
	  },
	  error: function(req, textStatus, errorThrown){
	  	console.log("error!");
	  },
	  complete: function(req,status){
	  	console.log("complete");
	  }
	}
	if (data){
		postdata.data = data;
		console.log("data: "+data);
	}
	$.ajax(postdata);	
}
function toggleExisting(event){
	if (mode!="existing"){
		$("#assoc-new-table").hide();
		$("#assoc-existing-table").show();
		mode = "existing";
		
		clearTable(mode);
		get({method: "list", mode: mode});
		
	}	
}
function toggleNew(event){
	if (mode!="new"){
		$("#assoc-existing-table").hide();
		$("#assoc-new-table").show();
		mode = "new";
		
		clearTable(mode);
		get({method: "list", mode: mode});
		
	}	
}
function clearTable(type){
	$("#assoc-"+type+"-table .assoc-row").remove();
}
function processData(data){
	//if ("error" in data){
	//	//alert(data["error"]);	
	//} else
	//try {
		quarters = data["quarters"];
		console.log("quarters: "+quarters);
		quarter = data["quarter"];
		initQuarters(quarters,quarter);
		$("#debug").innerHTML+="Method: "+data["method"]+"<br/>";
		if (data["method"]=="list" || 
			(data["videos"] && data["choices"])){
			appendToTable(data);	
		}	
	//} catch(e) {
	//	console.log(e);
	//}
}
function initQuarters(quarters,quarter){
	var qlist = $("#quarter-list");
	qlist.empty();
	qlist.append("Quarters: ");
	$.each(quarters,function(index, value){
		if (value!=quarter)
			qlist.append("<a value=\""+value+"\" href=\"javascript:void\">Q"+value+"</a>");
		else
			qlist.append("Q"+value);
		if (index<quarters.length-1){
			qlist.append(" | ");	
		}
	});
	$("#quarter-list a").each(function(index){
		$(this).click(function(){
			var quarter = $(this).attr("value");
			clearTable(mode);
			get({method: "list", mode: mode, quarter: quarter});	
		});
	});
	
	//.click(function(){
		//var quarter = event.target.getAttribute("value");
		//var quarter = $(this).attr("value");
		//clearTable(mode);
		//get({method: "list", mode: mode, quarter: quarter});
	//});
}
function appendToTable(data){
	var table = document.getElementById("assoc-"+data["mode"]+"-table");
	console.log("table: "+table);
	videos = data["videos"];
	choices = data["choices"];
	for (var vididx in videos){
		var vid = videos[vididx];
		//console.log("idx: "+vididx);
		var tr = document.createElement("tr");
		tr.setAttribute("class","assoc-row");
		table.appendChild(tr);
		//tr.innerHTML="<td class=\"vidfilecol\">"+quarter+"//"+vid[0].filename+"</td>"+
		//	"<td class=\"anglescol\"></td>"+
		//	"<td class=\"savecol\"></td>"+
		//	"<td class=\"playcol\"></td>";		
		//tr.append($("<td class=\"vidfilecol\">"+quarter+"//"+vid[0].filename+"</td>"));
		//tr.append($("<td class=\"anglescol\"></td>"));
		
		tr.appendChild(createVidFiles(vid[0]));
		tr.appendChild(createAngles(vid[0],data));
		tr.appendChild(createPlays(vid[0],choices));
	}
}
function createVidFiles(vid){
	var td = document.createElement("td");
	td.setAttribute("class","vidfilecol");
	td.innerHTML=quarter+"/"+vid.filename;
	return td;
}
function createAngles(vid,data){
	var td = document.createElement("td");
	td.setAttribute("class","anglescol");
	//<?=Check::constructVideoLink($angles[$a][webpath], $angles[$a][filename], "download", "MOBILE_MP4")
	//<video controls="true" preload="metadata"src="?>"></video>
	td.innerHTML = "<video width=\"318\" height=\"238\" controls=\"true\" preload=\"none\" src=\""+
		constructVideoLink(data,vid["webpath"],vid["filename"],"download","MOBILE_MP4")+
		"\" poster=\""+
	    constructVideoLink(data,vid["webpath"],vid["filename"],"download","MOBILE_MP4","jpg")+
		"\"></video>";
	return td;
}
function createPlays(vid,choices){
	var td = document.createElement("td");
	td.setAttribute("class","playscol");
	
	if (vid["old_text"].length > 0){
		td.innerHTML = "Old Play Text: "+vid["old_text"]+"<br/>";	
	}
	playid = vid["playid"];
	var selecte = document.createElement("select");
	selecte.setAttribute("size",12);
	td.appendChild(selecte);
	var toselect = 0;
	for (var i in choices){
		//console.log("i: "+i);
		var choice = choices[i];
		var cid = choice.value;
		var ctext = choice.text;
		
		var option = document.createElement("option");
		option.setAttribute("value",cid);
		if (cid==playid){
			toselect = i;
			//option.setAttribute("selected","true");	
		}
		option.innerHTML = ctext;
		selecte.appendChild(option);
	}
	//hackish: Use settimeout and javascript to set the index so the list
	//scrolls to the selected option
	//setting selected on the option attribute above will not make
	//the list scroll to the option
	setTimeout(function(){
		selecte.selectedIndex = toselect;
	},1000);
	td.appendChild(document.createElement("br"));
	var submitbtn = document.createElement("button");
	submitbtn.setAttribute("value",vid.videoid);
	submitbtn.setAttribute("name","Q"+quarter+"/"+vid.filename);
	submitbtn.innerHTML="Submit";
	td.appendChild(submitbtn);
	$(submitbtn).click(submitChange);
	return td;
}
function submitChange(){
	console.log("submit clicked");
	//get playid and video id
	var vidid = $(this).attr("value");
	var playid = $(this).parent().children("select").attr("value");
	var name = $(this).attr("name");
	console.log("vid id: "+vidid+" play: "+playid+" name: "+name);
	
	get({
		method: "assoc", mode: mode, quarter: quarter,
		videoid: vidid, playid: playid
	},true);
	
	//Remove videoid
	//submit - td  -   tr
	$(this).parent().parent().remove();
}
function constructVideoLink(data,webpath,filename,mode,type,ext){
	type = type.toLowerCase();
	if (!ext)
		ext = data["extensions"][type+"/"];
	//console.log("extensions: "+data["extensions"]);
	//for (exta in data["extensions"]){
	//	console.log("ext: "+exta+": "+data["extensions"][exta]);	
	//}
	var link = data["path"][mode];
	//console.log("link: "+link);
	//console.log("webpath: "+webpath);
	//console.log("type: "+type);
	//console.log("filename: "+filename);
	//console.log("ext: "+ext);
	link = link+"/" + webpath + type + "/" + filename + "." + ext;
	//console.log("path: "+link);
    return link;
}
$(document).ready(function(){
   init();
 });
