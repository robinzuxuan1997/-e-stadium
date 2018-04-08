Ext.define('FriendFinder.view.site.Card', {
    extend: 'Ext.Panel',
    xtype: 'siteview',
	
	requires: ['Ext.form.FieldSet', 'Ext.form.Password', 'Ext.Label', 'Ext.util.DelayedTask'],

    config: {

        title: 'EStadium',
        iconCls: 'home',

        autoDestroy: false,
		
		scrollable: {
			direction: 'vertical',
			directionLock: true
		},

        items: [
			{
				docked: 'top',
				xtype: 'titlebar',
				title: 'My Account',
				items: [
					{
						xtype: 'button',
						itemId: 'saveButton',
						text: 'Save'
					}
				]
			},
            {
				xtype: 'fieldset',
				title: 'Account Information',
				instructions: 'Username and Password must contain at least 4 characters',
				items: [
					{
						xtype: 'textfield',
						label: 'Username',
						itemId: 'userNameTextField',
						name: 'userNameTextField',
						required: true
					},
					{
						xtype: 'passwordfield',
						label: 'Password',
						itemId: 'passwordTextField',
						name: 'passwordTextField',
						required: true
					}
				]
			},
			{
				xtype: 'fieldset',
				title: 'About Yourself',
				items: [
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
					},
					{
						xtype: 'textfield',
						label: 'Age',
						itemId: 'ageTextField',
						name: 'ageTextField'
					}
				]
			}
        ],
		listeners: [
			{
				delegate: '#saveButton',
				event: 'tap',
				fn: 'onSaveButtonTap'
			}
		]
    },
	onSaveButtonTap: function () {
		var account = {};
		account.username = this.down('#userNameTextField').getValue();
		account.password = this.down('#passwordTextField').getValue();
		account.firstname = this.down('#firstNameTextField').getValue();
		account.lastname = this.down('#lastNameTextField').getValue();
		account.age = this.down('#ageTextField').getValue();
        this.fireEvent('updateAccountCommand',account);
    }
	
});
