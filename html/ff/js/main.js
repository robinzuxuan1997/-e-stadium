
function checkLogin(usrName, pwd){
	// TODO: Ajax request to validate user here!!!!!!!
	var loginRequest = $.ajax({
		type: "GET",
		url: "../checklogin.php",
		data: {usrName: usrName, pwd: pwd},
		beforeSend : function(xhr) {
			$.mobile.showPageLoadingMsg("a", "Logging on...");
		},
		complete : function() {
			$.mobile.hidePageLoadingMsg();
		}
	});
	loginRequest.done( function(data){
		try{
			var loginResult = $.parseJSON(data);
		}
		catch(ex){
			alert("Internal login error");
			return
		}
		if(loginResult.status == "success"){
			alert("success");
			$.mobile.changePage( $("#main"), "slide", true, true);
			loadMapChangePage();
		}
		else{
			alert("Wrong username or password");
		}
	});
	loginRequest.fail( function(){
		alert("ERROR MAKING AJAX REQUEST");	
	});
}
