Ext.define('FriendFinder.controller.Account', {
    extend: 'FriendFinder.controller.MainMenu',
    config: {
        refs: {
            loginView: 'loginview',
			mainMenuView: 'mainmenuview',
			accountContainer: 'mainmenuview accountview'
        },
        control: {
            mainMenuView: {
				populateCommand: 'onPopulateHomeScreenCommand'
				
			},
			accountContainer: {
				updateAccountCommand: 'onUpdateAccountCommand'
			}
        }
    },
	
	accountInfo: 0,

    onPopulateHomeScreenCommand: function (account) {
		console.log('onPopulateHomeScreenCommand');
		this.getMainMenuView().down('#userNameTextField').setValue(account.username);
		this.getMainMenuView().down('#passwordTextField').setValue(account.password);
		this.getMainMenuView().down('#firstNameTextField').setValue(account.firstname);
		this.getMainMenuView().down('#lastNameTextField').setValue(account.lastname);
		this.getMainMenuView().down('#ageTextField').setValue(account.age);
		//console.log(this.accountInfo);
	},
	
	onUpdateAccountCommand: function(account){
		console.log('onUpdateAccountCommand');
		var me = this;
		Ext.Ajax.request({
            url: 'updateAccount.php',
            method: 'GET',
            params: {
				uid: me.accountInfo.uid, //uid never changes
                username: account.username,
                password: account.password,
				firstname: (account.firstname)?(account.firstname):' ',
				lastname: (account.lastname)?(account.lastname):' ',
				age: (account.age)?(account.age):'0'
            },
            success: function (response) {

                var updateResponse = Ext.JSON.decode(response.responseText);

                if (updateResponse.status === "success") {
                    // The server will send a token that can be used throughout the app to confirm that the user is authenticated.
                    me.updateAccountSuccess(updateResponse.message);     //Just simulating success.
                } else {
                    me.updateAccountFailure(updateResponse.message);
                }
            },
            failure: function (response) {
				console.log('updateAccount.php failed');
                alert('Failed to create an account. Please try again later.');
            }
        });
	},
	
	updateAccountSuccess: function(message){
		alert(message);
	},
	
	updateAccountFailure: function(message){
		alert(message);
	}
});
