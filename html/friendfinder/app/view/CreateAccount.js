Ext.define('FriendFinder.view.CreateAccount', {
    extend: 'Ext.form.Panel',
    alias: "widget.createaccountview",
    requires: ['Ext.form.FieldSet', 'Ext.form.Password', 'Ext.Label', 'Ext.util.DelayedTask'],
    config: {
        title: 'Login',
        items: [
			{
				docked: 'top',
				xtype: 'titlebar',
				title: 'New Account',
				items: [
					{
						xtype: 'button',
						ui: 'back',
						itemId: 'backButton',
						text: 'Back'
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
			},
			{
				xtype: 'toolbar',
				docked: 'bottom',
				layout: { pack: 'center' },
				items: {
					xtype: 'button',
					text: 'Create',
					itemId: 'createButton'
				}
			}
		],
		listeners: [
			{
				delegate: '#backButton',
				event: 'tap',
				fn: 'onBackButtonTap'
			},
			{
				delegate: '#createButton',
				event: 'tap',
				fn: 'onCreateButtonTap'
			}
		]
	},
	onBackButtonTap: function () {
		this.down('#userNameTextField').setValue('');
		this.down('#passwordTextField').setValue('');
		this.down('#firstNameTextField').setValue('');
		this.down('#lastNameTextField').setValue('');
		this.down('#ageTextField').setValue('');
        this.fireEvent('backButtonCommand');
    },
	
	onCreateButtonTap: function() {
		var me = this,
            usernameField = me.down('#userNameTextField'),
            passwordField = me.down('#passwordTextField'),
            firstnameField = me.down('#firstNameTextField'),
			lastnameField = me.down('#lastNameTextField'),
			ageField = me.down('#ageTextField'),
            username = usernameField.getValue(),
            password = passwordField.getValue();
			firstname = firstnameField.getValue();
			lastname = lastnameField.getValue();
			age = ageField.getValue();

        // Using a delayed task in order to give the hide animation above
        // time to finish before executing the next steps.
        var task = Ext.create('Ext.util.DelayedTask', function () {

            me.fireEvent('createCommand', me, username, password, firstname, lastname, age);

            usernameField.setValue('');
            passwordField.setValue('');
			firstnameField.setValue('');
			lastnameField.setValue('');
			ageField.setValue('');
        });

        task.delay(500);
	}
});