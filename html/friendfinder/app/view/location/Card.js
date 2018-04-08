Ext.define('FriendFinder.view.location.Card', {
    extend: 'Ext.Panel',
    xtype: 'locationview',
	
	requires: ['Ext.Map'],
	requires: ['Ext.field.Search'],
    config: {

        title: 'Location',
        iconCls: 'locate',
		
		layout: 'vbox',

        items: [
            {
				docked: 'top',
				xtype: 'titlebar',
				style: 'background-color: #CFB53B;',
				title: 'FF',
				items: [
					{
						xtype: 'button',
						itemId: 'checkInButton',
						text: 'Check In'
					},
					{
						xtype: 'button',
						itemId: 'addFriendButton',
						text: 'Add Friend'
					
					},
				// TODO: WE WANT TO MOVE THIS 
				//	{
				//		xtype: 'button',
				//		itemId: 'menuButton',
				//		text: 'Menu'
				//	},
				//	TODO: Show friend button should eventually be removed, friends should automatically be shown
					{	
					  	// SEARCH BAR HERE
					  	xtype: 'searchfield'			
					}
				]
            
            },            
			{
				xtype: 'map',
				id: 'locationMap',
				flex: 1,
				layout: 'fullscreen',
				useCurrentLocation: true,
				mapOptions : {
					//center : new google.maps.LatLng(33.77829120, -84.39903240),  //Georgia Tech
					zoom : 15,
					mapTypeId : google.maps.MapTypeId.ROADMAP,
					navigationControl: true,
					navigationControlOptions: {
						style: google.maps.NavigationControlStyle.DEFAULT
					}
				}
			}
        ],
		
		listeners: [
			{
				delegate: '#checkInButton',
				event: 'tap',
				fn: 'onCheckInButtonTap'
			},			
			{
				delegate: '#addFriendButton',
				event: 'tap',
				fn: 'onAddFriendButtonTap'

			}
			/**{
				delegate: '#locationMap',		
				event: 'show',
				fn: 'onLoad'
			}**/
		]
    },
	
	onCheckInButtonTap: function() {
		this.fireEvent('CheckInLocationCommand');
	},
	
	onAddFriendButtonTap: function(){
		this.fireEvent('AddFriendCommand');
	}
});
