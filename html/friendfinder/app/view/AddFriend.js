Ext.define('FriendFinder.view.AddFriend', {
    extend: 'Ext.Panel',
    
	alias: 'widget.addfriendview',
	requires: ['Ext.form.FieldSet', 'Ext.Label', 'Ext.util.DelayedTask'],
	
    config: {

        title: 'Add Friend',
        //xtype: 'accountview',

        autoDestroy: false,
		
		scrollable: {
			direction: 'vertical',
			directionLock: true
		},

        items: [
			{
				docked: 'top',
				xtype: 'titlebar',
				title: 'Add Friend',
				items: [
					{
						xtype: 'button',
						itemId: 'backButton',
						text: 'Back'
					}
				]
			},
			{
				xtype: 'fieldset',
				title: 'Search for user:',
				items: [
					{
						xtype: 'textfield',
						label: 'Username:',
						itemId: 'userNameTextField',
						name: 'userNameTextField'
				        },
					{
						xtype: 'textfield',
						label: 'First Name',
						itemId: 'firstNameTextField',
						name: 'firstNameTextField'
					},
					{
						xtype: 'textfield',
						label: 'Last Name',
						itemId: 'lastNameTextField',
						name: 'lastNameTextField'
					}
				]
			}, {
				xtype: 'button',
				text: 'Search',
				padding: '10px;',
				name: 'addFriendButton',
				style: 'background-image: none; background-color: yellow;'
			}
        ],
		listeners: [
			{
				delegate: '#addFriendButton',
				event: 'tap',
				fn: 'onAddFriendButtonTap'

			}
		]
    }
	
});
