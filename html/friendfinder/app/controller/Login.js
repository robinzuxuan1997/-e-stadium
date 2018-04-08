Ext.define('FriendFinder.controller.Login', {
    extend: 'Ext.app.Controller',
    config: {
        refs: {
            loginView: 'loginview',
			createAccountView: 'createaccountview',
            mainMenuView: 'mainmenuview'
        },
        control: {
            loginView: {
                signInCommand: 'onSignInCommand',
				createAccountCommand: 'onCreateAccountCommand'
            },
			createAccountView: {
				backButtonCommand: 'onBackCommand',
				createCommand: 'onCreateCommand'
			},
            mainMenuView: {
                SignOffCommand: 'onSignOffCommand'
            }
        }
    },

    // Session token

    sessionToken: null,
	accountInfo: null,

    // Transitions
    getSlideLeftTransition: function () {
        return { type: 'slide', direction: 'left' };
    },

    getSlideRightTransition: function () {
        return { type: 'slide', direction: 'right' };
    },

    onSignInCommand: function (view, username, password) {

        //console.log('Username: ' + username + '\n' + 'Password: ' + password);

        var me = this,
            loginView = me.getLoginView();

        if (username.length === 0 || password.length === 0) {

            loginView.showSignInFailedMessage('Please enter your username and password.');
            return;
        }

        loginView.setMasked({
            xtype: 'loadmask',
            message: 'Signing In...'
        });

        Ext.Ajax.request({
            url: 'login.php',
            method: 'GET',
            params: {
                username: username,
                password: password
            },
            success: function (response) {

                var loginResponse = Ext.JSON.decode(response.responseText);

                if (loginResponse.status === "success") {
                    // The server will send a token that can be used throughout the app to confirm that the user is authenticated.
                    me.sessionToken = loginResponse.sessionToken;
					me.accountInfo = loginResponse.accountInfo;
                    me.signInSuccess();     //Just simulating success.
                } else {
                    me.singInFailure(loginResponse.message);
                }
            },
            failure: function (response) {
                me.sessionToken = null;
				me.uid = null;
                me.singInFailure('Login failed. Please try again later.');
            }
        });
    },

    signInSuccess: function () {
        console.log('User ' + this.accountInfo.firstname + ' signed in.');
		Ext.Viewport.add({xtype: 'mainmenuview' });
        var loginView = this.getLoginView();
        var mainMenuView = this.getMainMenuView();
        loginView.setMasked(false);
		
		// Populate Homescreen Command
		mainMenuView.fireEvent('populateCommand',this.accountInfo);
		
        Ext.Viewport.animateActiveItem(mainMenuView, this.getSlideLeftTransition());
    },

    singInFailure: function (message) {
        var loginView = this.getLoginView();
        loginView.showSignInFailedMessage(message);
        loginView.setMasked(false);
    },

    onSignOffCommand: function () {

        var me = this;

        /*
		Ext.Ajax.request({
            url: '../../services/logoff.ashx',
            method: 'post',
            params: {
                sessionToken: me.sessionToken
            },
            success: function (response) {

                // TODO: You need to handle this condition.
            },
            failure: function (response) {

                // TODO: You need to handle this condition.
            }
        }); 
		*/

        Ext.Viewport.animateActiveItem(this.getLoginView(), this.getSlideRightTransition());
    },
	
	onCreateAccountCommand: function () {
		// create the account view
		Ext.Viewport.add({xtype: 'createaccountview'}); 
		// show create account view
		Ext.Viewport.animateActiveItem(this.getCreateAccountView(), this.getSlideLeftTransition());
	},
	
	onBackCommand: function () {
		var me = this;
		// show login view
		Ext.Viewport.animateActiveItem(this.getLoginView(), this.getSlideRightTransition());
		
		// remove component ONLY after animation finishes
		var task = Ext.create('Ext.util.DelayedTask', function () {
            // destroy create account view component
			Ext.Viewport.remove(me.getCreateAccountView());
        });
        task.delay(500); // KEEP
	},
	
	onCreateCommand: function (view, username, password, firstname, lastname, age) {
		var me = this,
            createAccountView = me.getCreateAccountView();

        if (username.length === 0 || password.length === 0) {

            alert('Please enter your username and password.');
            return;
        }

        createAccountView.setMasked({
            xtype: 'loadmask',
            message: 'Signing In...'
        });

        Ext.Ajax.request({
            url: 'createAccount.php',
            method: 'GET',
            params: {
                username: username,
                password: password,
				firstname: (firstname)?(firstname):' ',
				lastname: (lastname)?(lastname):' ',
				age: (age)?(age):'0'
            },
            success: function (response) {

                var loginResponse = Ext.JSON.decode(response.responseText);

                if (loginResponse.status === "success") {
                    // The server will send a token that can be used throughout the app to confirm that the user is authenticated.
                    me.sessionToken = loginResponse.sessionToken;
                    me.createAccountSuccess();     //Just simulating success.
                } else {
                    me.createAccountFailure(loginResponse.message);
                }
            },
            failure: function (response) {
                me.sessionToken = null;
				console.log('createAccount.php failed');
                alert('Failed to create an account. Please try again later.');
            }
        });
	},
	
	createAccountSuccess: function () {
        console.log('Account created');
		
        var createAccountView = this.getCreateAccountView();
        createAccountView.setMasked(false);

        Ext.Viewport.animateActiveItem(this.getLoginView(), this.getSlideRightTransition());
		
		// remove component ONLY after animation finishes
		var task = Ext.create('Ext.util.DelayedTask', function () {
            // destroy create account view component
			Ext.Viewport.remove(createAccountView);
        });
        task.delay(500); // KEEP
		
		alert('Account Successfully Created');
    },

    createAccountFailure: function (message) {
        var createAccountView = this.getCreateAccountView();
        createAccountView.setMasked(false);
		
		// remove component ONLY after animation finishes
		var task = Ext.create('Ext.util.DelayedTask', function () {
            // destroy create account view component
			Ext.Viewport.remove(createAccountView);
        });
        task.delay(500); // KEEP
		
		alert(message);
    }
});
