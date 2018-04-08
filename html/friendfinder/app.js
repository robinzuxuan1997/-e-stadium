//<debug>
Ext.Loader.setPath({
    'Ext': 'touch/src',
    'FriendFinder': 'app'
});
//</debug>

Ext.application({
    name: 'FriendFinder',

    requires: [
        'Ext.MessageBox',
		'Ext.device.Geolocation'
    ],

    views: ['Login','CreateAccount','MainMenu',
			'account.Card','location.Card','AddFriend'],
	controllers:['Login','MainMenu','Location','Account'],

    icon: {
        /*'57': 'resources/icons/Icon.png',
        '72': 'resources/icons/Icon~ipad.png',
        '114': 'resources/icons/Icon@2x.png',
        '144': 'resources/icons/Icon~ipad@2x.png'*/
    },

    isIconPrecomposed: true,

    startupImage: {
        /*'320x460': 'resources/startup/320x460.jpg',
        '640x920': 'resources/startup/640x920.png',
        '768x1004': 'resources/startup/768x1004.png',
        '748x1024': 'resources/startup/748x1024.png',
        '1536x2008': 'resources/startup/1536x2008.png',
        '1496x2048': 'resources/startup/1496x2048.png'*/
    },
    
    viewport: {
    	autoMaximize: true
    },

    launch: function() {
        // Destroy the #appLoadingIndicator element
        Ext.fly('appLoadingIndicator').destroy();

        // Initialize the main view
        Ext.Viewport.add([
			{xtype: 'loginview'}
			//{xtype: 'createaccountview'},
			//{xtype: 'mainmenuview' },
		]);
    },

    onUpdated: function() {
        Ext.Msg.confirm(
            "Application Update",
            "This application has just successfully been updated to the latest version. Reload now?",
            function(buttonId) {
                if (buttonId === 'yes') {
                    window.location.reload();
                }
            }
        );
    }
});
