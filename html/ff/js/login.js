        $(document).ready( function() {
                // LOGIN BUTTON CLICKED
                $("#btnLogin").click( function() {
                        // check login
                        checkLogin($("#usrName").val(), $("#pwd").val());       
                });

                // CREATE ACCOUNT BUTTON CLICKED
                $("#btnCreateAccount").click( function() {
                        // navigate to create account page
                        $.mobile.changePage("#createaccount", "slide", true, true);
                });
        });