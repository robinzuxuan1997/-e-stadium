Ext.define('FriendFinder.controller.MainMenu', {
	extend: 'Ext.app.Controller',
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
		this.accountInfo = account;
		//rest implemented in Account.js controller
	},
	
	onUpdateAccountCommand: function(account){
		//implemented in Account.js controller
	}
	
});

