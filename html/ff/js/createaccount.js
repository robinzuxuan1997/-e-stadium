$(document).ready( function() {
	$("#submit").click( function() {
		addUser($("#fname").val(), $("#lname").val(), $("#age").val(), $("#username").val(), $("#password").val());
	});
});


function addUser(fname, lname, age, usrName, pwd){
	var addUserRequest = $.ajax({
		type: "POST",
		url: "../addUser.php",
		data: {fname : fname, lname : lname, age : age, usrName : usrName, pwd : pwd},
		beforeSend : function(xhr) {
			$.mobile.showPageLoadingMsg("a", "Adding user...");
		},
		complete : function(jqXHR, textStatus) {
			$.mobile.hidePageLoadingMsg();
		}
	});
		addUserRequest.done( function(data){
			try{
				var returnVal = $.parseJSON(data);
			}
			catch(ex){
				alert("Internal error");
				return;
			}
			if(returnVal.status == "success"){
				alert("Successfully added user!");
				$.mobile.changePage( $("#login"), "slide", true, true);
			}
			else{
				alert(returnVal.message);
			}
	});
		addUserRequest.fail( function(){
			alert("ERROR MAKING AJAX REQUEST");	
	});
}
