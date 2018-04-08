Ext.define('FriendFinder.view.MainMenu', {
    extend: 'Ext.TabPanel',
    requires: ['Ext.TitleBar'],
    alias: 'widget.mainmenuview',
    config: {
    	fullscreen: true,
        tabBarPosition: 'bottom',
		tabBar: {
			//ui: 'gray'
		},
        items: [
        		{ xclass: 'FriendFinder.view.location.Card' },
        		{ xclass: 'FriendFinder.view.site.Card' },
			    { xclass: 'FriendFinder.view.friends.Card' },
			    { xclass: 'FriendFinder.view.notifications.Card' },
			    { xclass: 'FriendFinder.view.account.Card' },
			    { xclass: 'FriendFinder.view.settings.Card'},
			    { xclass: 'FriendFinder.view.about.Card'}
				]
    },
    onLogOffButtonTap: function () {
        this.fireEvent('SignOffCommand');
    }
});
