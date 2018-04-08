Ext.define('FriendFinder.controller.Location', {
    extend: 'FriendFinder.controller.MainMenu',
    config: {
        refs: {
            loginView: 'loginview',
            mainMenuView: 'mainmenuview',
			locationView: 'mainmenuview locationview',
			locationMap: 'map[id=locationMap]'
        },
        control: {
            mainMenuView: {
                SignOffCommand: 'onSignOffCommand'
            },
			locationView: {
				CheckInLocationCommand: 'onCheckInLocationButtonTap',
				ShowFriendLocationCommand: 'onShowFriendLocationCommand',
				RemoveAllMarkerCommand: 'onRemoveAllMarkerCommand',
				AddFriendCommand: 'onAddFriendCommand'
			},
			locationMap: {
				initialize: function(){
					console.log('map initialized');
					this.onCheckInLocationButtonTap(); //Does not pan to position
					//this.onShowFriendLocationCommand(); //Does not show friends
				}				
			}
        }
    },
	
	accountInfo: 0,
	//userMarker: [],
	friendMarkers: [],
	friendCount: 0,
	userMarker: null,
	friendMarkersShown: false,

    // Transitions
    getSlideLeftTransition: function () {
        return { type: 'slide', direction: 'left' };
    },

    getSlideRightTransition: function () {
        return { type: 'slide', direction: 'right' };
    },
	
	onShowFriendLocationCommand: function() {
		console.log('onShowFriendLocationCommand');
		var uid = this.accountInfo.uid;
		var mapComponent = Ext.getCmp('locationMap');
		var me = this;
		
		var createMarker = function (obj) {
			console.log(obj.lat+','+obj.lng);
			imgUrl = 'resources/images/greendot.png';
			
			//Would have to change later based on length of game/whether this is used outside of games
			var objUTCDateTime = new Date(obj.logtime + " UTC"); //Make sure this works
			var currentTime = new Date();
			var timePassed = currentTime - objUTCDateTime;
			
			//Change color of marker based on time of last check in
			if (timePassed >= 7200000) //Two hours
			 	imgUrl = 'resources/images/reddot.png';
			else if (1800000 <= timePassed && timePassed < 7200000) //30 minutes and two hours
			    imgUrl = 'resources/images/yellowdot.png';
						
			// Current Location Marker Image
			var image = new google.maps.MarkerImage(
				imgUrl,
				null,
				null,		
				new google.maps.Point(8,8),
				new google.maps.Size(17,17)
			);
			
			var marker = new google.maps.Marker({
				map: mapComponent.getMap(),
				icon: image,
				position: new google.maps.LatLng(obj.lat,obj.lng),
				title: obj.firstname.toLowerCase() + obj.lastname.toLowerCase(), //Done for easy searching
				optimized: false
			});
			
			var pulseColor = "#199306"; //Default green color
			if (imgUrl == 'resources/images/reddot.png')
				pulseColor = "#f01313";
			else if (imgUrl == 'resources/images/yellowdot.png')
				pulseColor = "#c9aa0a";
			
			var css = document.createElement("style");
			css.type = "text/css";
			css.innerHTML = "@-webkit-keyframes locationPulse {\
							from {\
								-webkit-transform: scale(0.25);\
								opacity: 1.0;\
							}\
							95% {\
								-webkit-transform: scale(1.3);\
								opacity: 0;\
							}\
							to {\
								-webkit-transform: scale(0.3);\
								opacity: 0;\
							}\
						}" + 					
						"#locationMap div[title=" + obj.firstname.toLowerCase() + obj.lastname.toLowerCase() + "] {\
						  		-webkit-animation: locationPulse 1.5s ease-in-out infinite;\
						        -moz-animation: locationPulse 1.5s ease-in-out infinite;\
						        animation: locationPulse 1.5s ease-in-out infinite;\
								border:1pt solid #fff;\
								/* make a circle */\
								-moz-border-radius:51px;\
								-webkit-border-radius:51px;\
								border-radius:51px;\
								/* multiply the shadows, inside and outside the circle */\
								-moz-box-shadow:inset 0 0 5px" + pulseColor + ", inset 0 0 5px" + pulseColor + ", inset 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ";\
								-webkit-box-shadow:inset 0 0 5px" + pulseColor + ", inset 0 0 5px" + pulseColor + ", inset 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ";\
								box-shadow:inset 0 0 5px" + pulseColor + ", inset 0 0 5px" + pulseColor + ", inset 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ", 0 0 5px" + pulseColor + ";\
								/* set the ring's new dimension and re-center it */\
								height:51px !important;\
								margin:-18px 0 0 -18px;\
								width:51px !important;\
						}" +
						"#locationMap div[title=" + obj.firstname.toLowerCase() + obj.lastname.toLowerCase() + "] img {\
								display:none;\
						}" + 						
						"/* compensate for iPhone and Android devices with high DPI, add iPad media query */\
						@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (device-width: 768px) {\
							#locationMap div[title=" + obj.firstname.toLowerCase() + obj.lastname.toLowerCase() + "] {\
								margin:-10px 0 0 -10px;\
							}\
						};";
			document.body.appendChild(css);
			
			me.friendMarkers.push(marker);
			
			// zoom in to level 16
			//mapComponent.getMap().setZoom(16);
			
			google.maps.event.addListener(marker, 'click', function() {
				if (!this.overlay){ // only create overlay once
					this.overlay = Ext.Viewport.add({
						xtype: 'panel',
						modal: true,
						hideOnMaskTap: true,
						centered: true,
						width: Ext.os.deviceType == 'Phone' ? 260 : 400,
						height: Ext.os.deviceType == 'Phone' ? 220 : 400,
						items: [
							{
								docked: 'top',
								xtype: 'toolbar',
								title: obj.firstname + ' ' + obj.lastname,
								item: [
									{
										xtype: 'button',
										text: 'Remove'
									}
								]
							},
							{
								html: '<p>' + obj.firstname + ' ' + obj.lastname + ' is ' + obj.age +' years old.' + '<br>' +
										'Last Check-In: ' + objUTCDateTime.toLocaleString() + '</p>'
							}
						],
						scrollable: true
					});
				}
				this.overlay.show(); //show overlay if it's hidden
			});
		};
		
		Ext.Ajax.request({
			url: 'getFriendship.php',
			method: 'GET',
			params: {
				userid: uid
			},
			success: function (response) {
				var loginResponse = Ext.JSON.decode(response.responseText);
				if (!this.friendMarkersShown){
					for (var i=0; i< loginResponse.length; i++) {
						createMarker(loginResponse[i]);
						me.friendCount++;
					}
					this.friendMarkersShown = true;
				}
			},
			failure: function (response) {
				console.log('Ajax failure');
			}
		}); //end Ajax Request
	},
	
	onCheckInLocationButtonTap: function () {
		console.log('onCheckInLocationButtonTap');
		var uid = this.accountInfo.uid;
		var latitude = 0, longitude = 0;
		
		var mapComponent = Ext.getCmp('locationMap');
		
		// Current Location Marker Image
		var image = new google.maps.MarkerImage(
			'resources/images/bluedot.png',
			null,
			null,		
			new google.maps.Point(8,8),
			new google.maps.Size(17,17)
		);
		
		var createMarker = function (lat,lng) {
			this.userMarker = new google.maps.Marker({
				map: mapComponent.getMap(),
				icon: image,
				position: new google.maps.LatLng(lat,lng),
				title: "You are here",
				optimized: false
			});
			
			// zoom in to level 16
			mapComponent.getMap().setZoom(16);
			
			var css = document.createElement("style");
			css.type = "text/css";
			css.innerHTML = "@-webkit-keyframes locationPulse {\
							from {\
								-webkit-transform: scale(0.25);\
								opacity: 1.0;\
							}\
							95% {\
								-webkit-transform: scale(1.3);\
								opacity: 0;\
							}\
							to {\
								-webkit-transform: scale(0.3);\
								opacity: 0;\
							}\
						}" + 					
						"#locationMap div[title='You are here'] {\
						  		-webkit-animation: locationPulse 1.5s ease-in-out infinite;\
						        -moz-animation: locationPulse 1.5s ease-in-out infinite;\
						        animation: locationPulse 1.5s ease-in-out infinite;\
								border:1pt solid #fff;\
								/* make a circle */\
								-moz-border-radius:51px;\
								-webkit-border-radius:51px;\
								border-radius:51px;\
								/* multiply the shadows, inside and outside the circle */\
								-moz-box-shadow:inset 0 0 5px #06f, inset 0 0 5px #06f, inset 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f;\
								-webkit-box-shadow:inset 0 0 5px #06f, inset 0 0 5px #06f, inset 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f;\
								box-shadow:inset 0 0 5px #06f, inset 0 0 5px #06f, inset 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f;\
								/* set the ring's new dimension and re-center it */\
								height:51px !important;\
								margin:-18px 0 0 -18px;\
								width:51px !important;\
						}" +
						"#locationMap div[title='You are here'] img {\
								display:none;\
						}" + 						
						"/* compensate for iPhone and Android devices with high DPI, add iPad media query */\
						@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (device-width: 768px) {\
							#locationMap div[title='You are here'] {\
								margin:-10px 0 0 -10px;\
							}\
						};";
			document.body.appendChild(css);
			mapComponent.getMap().panTo(new google.maps.LatLng(latitude,longitude));
			/**google.maps.event.addListener(marker, 'click', function() {
				console.log('Marker Clicked');
				marker.setMap(null); // remove the marker from map
			});**/
		};
		
		// Check for geolocation support
		if (navigator.geolocation) {
			// Use method getCurrentPosition to get coordinates
			navigator.geolocation.getCurrentPosition(function (position) {
				latitude = position.coords.latitude;
				longitude = position.coords.longitude;
				//var actualTime = new Date(new Date() - 14400000);
				logTime = new Date().toJSON(); 
				//console.log('uid: ' + uid + ', location: (' + latitude + ',' + longitude + '),' + 'logTime: ' + logTime  );
				
				Ext.Ajax.request({
					url: 'updateLocation.php',
					method: 'GET',
					params: {
						uid: uid,
						latitude: latitude,
						longitude: longitude,
						logtime: logTime //DateTime isn't updating on server
					},
					success: function (response) {
						var loginResponse = Ext.JSON.decode(response.responseText);

						if (loginResponse.status === "success") {
							//alert('success! Lat:' + latitude + ', Long:' + longitude);
							if (!this.userMarker)
								createMarker(latitude, longitude);
							else{
								this.userMarker.setPosition(new google.maps.LatLng(latitude,longitude));
							}
                                                 mapComponent.getMap().setCenter(new google.maps.LatLng(latitude,longitude));
						} else {
							console.log('response failed');
						}
					},
					failure: function (response) {
						console.log('Ajax failure');
					}
				}); //end Ajax Request
			});
		} // end if (navigator.geolocation)
		else {
			alert('Geolocation is not supported');
		}
	},

	onAddFriendCommand: function(){
		try{
			var addFriendView = Ext.create('FriendFinder.view.AddFriend');
			Ext.Viewport.setActiveItem(addFriendView);
		}
		catch(ex){
			alert(ex.message)
		}
	},
	
	onRemoveAllMarkerCommand: function() {
		for (var i = 0; i < this.friendMarkers.length; i++ ) {
			this.friendMarkers[i].setMap(null);
		}
	}
});
