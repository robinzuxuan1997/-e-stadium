angular.module('estadium.controllers', [])

    .controller('AppCtrl', ['$scope', '$ionicModal', 'eStadium', function ($scope, $ionicModal, eStadium) {
        // Load modal
        $ionicModal.fromTemplateUrl('templates/history-switcher.html', {
            scope: $scope,
            animation: 'slide-in-up'
        }).then(function (modal) {
            $scope.modal = modal;
        });

        $scope.refreshClicked = function () {
            eStadium.nullifyAllData();
            $scope.refreshAll();
        };

        $scope.historyClicked = function () {
            $scope.modal.show();
        };

        $scope.historyConfirmed = function (game_id) {
            $scope.modal.hide();
            eStadium.switchCurrentGame(game_id);
            $scope.refreshAll();
        };

        $scope.revertConfirmed = function () {
            $scope.modal.hide();
            eStadium.revertBackToOngoingGame();
            $scope.refreshAll();
        };

        // Modal functions
        $scope.closeModal = function () {
            $scope.modal.hide();
        };
        $scope.$on('$destroy', function () {
            $scope.modal.remove();
        });

        // Helper functions
        $scope.refreshAll = function () {
            $scope.$broadcast('refresh', {});
        }
    }])

    .controller('HomepageCtrl', ['$scope', '$ionicModal','$ionicPopup','eStadium', 'host', function ($scope, $ionicModal,$ionicPopup, eStadium, host) {

        $scope.play = false;
        function render() {

            $ionicModal.fromTemplateUrl('templates/video-player.html', {
                scope: $scope,
                animation: 'slide-in-up'
            }).then(function (modal) {
                $scope.modal = modal;
            });

            // Modal functions
            $scope.openModal = function (title, videos) {
                var video_paths = videos.map(function (video) {
                    return host + '/videos/' + video.path + 'raw/' + video.filename + '.mp4';
                });

                //Check the current cookie content
                var i = eStadium.checkCookie();
                if (i == 0){
                    //When the cookie does not match password, ask user to input password
                    $ionicPopup.prompt({
                        title: 'Enter the Password',
                        inputType: 'password',
                        inputPlaceholder: 'Please input your password'
                    }).then(function(res) {
                        console.log('Your password is', res);
                        eStadium.setCookie('password',res,1);
                        if (res == '2020') {
                            //Just show the video
                            $scope.play = true;
                            $scope.videoPlayerInfo = {
                                title: title,
                                videos_paths: video_paths
                            };
                            console.log("Show modal next.");
                            $scope.modal.show().then(function () {});
                        }
                        else if (res == undefined){
                            //Do nothing;close the popup
                            console.log("res == undefined")
                        }
                        else{
                            //Say you got your password wrong
                            console.log("Wrong password!");
                            $ionicPopup.alert({
                                title: 'Status',
                                template: 'Wrong password'
                                });
                        }
                    });
                }
                else
                {
                    //When cookie matches password, show the video
                    console.log("this is the else block");
                    $scope.videoPlayerInfo = {
                        title: title,
                        videos_paths: video_paths
                    };
                    $scope.modal.show().then(function () {});
                }
            };

            $scope.closeModal = function () {
                $scope.modal.hide();
            };
            $scope.$on('$destroy', function () {
                $scope.modal.remove();
            });

            // Load data
            eStadium.getScoringSummary().then(function (data) {
                // Data from the service
                $scope.global_data = data.global_data;
                $scope.data = data.data;

                // Computed data for the view
                $scope.hide_over_Q = ($scope.global_data.home_quarter_scores.OverQ === 0);
            }).catch(function (error) {
                console.error(error)
            });
        }

        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }])

    .controller('TeamStatsCtrl', ['$scope', 'eStadium', 'ObjectUtils', function ($scope, eStadium, ObjectUtils) {
        function render() {
            eStadium.getTeamStatsData().then(function (data) {
                // Data from the service
                $scope.global_data = data.global_data;

                // Computed data for the view
                var converted_home_stats = ObjectUtils.convertTeamStats(data.data.home_stats);
                var converted_away_stats = ObjectUtils.convertTeamStats(data.data.away_stats);
                $scope.data = {
                    'home_stats': converted_home_stats,
                    'away_stats': converted_away_stats
                }
            }).catch(function (error) {
                console.error(error);
            });
        }

        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }])

    .controller('OffenseCtrl', ['$scope', 'eStadium', 'host', function ($scope, eStadium, host) {
        function render() {
            eStadium.getPlayerStats().then(function (data) {
                $scope.global_data = data.global_data;
                $scope.myFilter = 'home';
                $scope.data = {

                    "passing": [
                        {
                            type: "home",
                            pass_stats: data.data.home_passing
                        },

                        {

                            type: "away",
                            pass_stats: data.data.away_passing
                        }
                    ],

                    "rushing": [
                        {
                            type: "home",
                            rush_stats: data.data.home_rushing

                        },

                        {

                            type: "away",
                            rush_stats: data.data.away_rushing
                        }

                    ],

                    "receiving": [
                        {
                            type: "home",
                            rec_stats: data.data.home_receiving


                        },
                        {
                            type: "away",
                            rec_stats: data.data.away_receiving
                        }

                    ]
                };

            }).catch(function (error) {
                console.error(error);
            });
        }


        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }])

    .controller('DefenseCtrl', ['$scope', 'eStadium', 'host', function ($scope, eStadium, host) {
        function render() {
            eStadium.getPlayerStats().then(function (data) {

                $scope.global_data = data.global_data;
                $scope.myFilter = 'home';
                $scope.data = {
                    "statistics": [
                        {
                            type: "home",
                            stats: data.data.home_defense
                        },
                        {
                            type: "away",
                            stats: data.data.away_defense
                        }]
                };

            }).catch(function (error) {
                console.error(error);
            });
        }


        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }])

    .controller('SpecialTeamsCtrl', ['$scope', 'eStadium', 'host', function ($scope, eStadium, host) {
        function render() {
            eStadium.getPlayerStats().then(function (data) {

                $scope.global_data = data.global_data;
                $scope.myFilter = 'home';
                $scope.data = {
                    "punting": [
                        {
                            type: "home",
                            stats: data.data.home_punting
                        },
                        {
                            type: "away",
                            stats: data.data.away_punting
                        }],

                    "returns": [
                        {
                            type: "home",
                            stats: data.data.home_returns
                        },
                        {
                            type: "away",
                            stats: data.data.away_returns
                        }],

                    "FGA": [
                        {
                            type: "home",
                            stats: data.data.home_FGA
                        },
                        {
                            type: "away",
                            stats: data.data.away_FGA

                        }],

                    "kickoffs": [
                        {
                            type: "home",
                            stats: data.data.home_kickoffs
                        },
                        {
                            type: "away",
                            stats: data.data.away_kickoffs

                        }]

                };


            }).catch(function (error) {
                console.error(error);
            });
        }

        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }])

    .controller('PlayByPlayCtrl', ['$scope', '$ionicModal','$ionicPopup','eStadium', 'host', 'ObjectUtils', function ($scope, $ionicModal, $ionicPopup,eStadium, host, ObjectUtils) {
        function render() {
            $ionicModal.fromTemplateUrl('templates/video-player.html', {
                scope: $scope,
                animation: 'slide-in-up'
            }).then(function (modal) {
                $scope.modal = modal;
            });

            $scope.openModal = function (title, videos) {
                var video_paths = videos.map(function (video) {
                    return host + '/videos/' + video.path + 'raw/' + video.filename + '.mp4';
                });

                //Check the current cookie content
                var i = eStadium.checkCookie();
                if (i == 0){
                    //When the cookie does not match password, ask user to input password
                    $ionicPopup.prompt({
                        title: 'Enter the Password',
                        inputType: 'password',
                        inputPlaceholder: 'Please input your password'
                    }).then(function(res) {
                        console.log('Your password is', res);
                        eStadium.setCookie('password',res,1);
                        if (res == '2020') {
                            //Just show the video
                            $scope.play = true;
                            $scope.videoPlayerInfo = {
                                title: title,
                                videos_paths: video_paths
                            };
                            console.log("Show modal next.");
                            $scope.modal.show().then(function () {});
                        }
                        else if (res == undefined){
                            //Do nothing;close the popup
                            console.log("res == undefined")
                        }
                        else{
                            //Say you got your password wrong
                            console.log("Wrong password!");
                            $ionicPopup.alert({
                                title: 'Status',
                                template: 'Wrong password'
                            });
                        }
                    });
                }
                else
                {
                    //When cookie matches password, show the video
                    console.log("this is the else block");
                    $scope.videoPlayerInfo = {
                        title: title,
                        videos_paths: video_paths
                    };
                    $scope.modal.show().then(function () {});
                }
            };

            $scope.closeModal = function () {
                $scope.modal.hide();
            };
            $scope.$on('$destroy', function () {
                $scope.modal.remove();
            });

            // Load data
            eStadium.getPlayByPlayData().then(function (data) {
                // Data from the service
                $scope.global_data = data.global_data;
                console.log($scope.global_data);
                $scope.data = data.data;
                console.log($scope.data);

                // Computed data for the view
                $scope.quarters = Object.keys($scope.data);
                console.log($scope.quarters);

                // Sanitize play type and add play type image to each play
                $scope.quarters.forEach(function (key) {
                    var plays = $scope.data[key];

                    plays.forEach(function (play, index) {
                        // Sanitize this play with correct play type
                        var sanitized_play = ObjectUtils.sanitizePlayType(play);

                        // Find the play type image path
                        sanitized_play.image_path = ObjectUtils.PLAY_TYPE_TO_IMAGE_PATH_MAPPING[sanitized_play.type];

                        // Replace old play with sanitized play
                        $scope.data[key][index] = sanitized_play;
                    })
                });

                // Current state of the view
                $scope.current_quarter = $scope.global_data.quarter == 'Q1' ? 1
                    : $scope.global_data.quarter == 'Q2' ? 2 : $scope.global_data.quarter == 'Q3' ? 3
                    : 4;
                $scope.per_tab_data = $scope.data[$scope.current_quarter];
                $scope.tabClicked = function (quarter) {
                    $scope.current_quarter = quarter;
                    $scope.per_tab_data = $scope.data[quarter];
                };
            }).catch(function (error) {
                console.error(error);
            })
        }

        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }])

    .controller('PopularPlayCtrl', ['$scope', '$ionicModal','$ionicPopup','eStadium', 'host', 'ObjectUtils', function ($scope, $ionicModal, $ionicPopup,eStadium, host, ObjectUtils) {
        function render() {
            $ionicModal.fromTemplateUrl('templates/video-player.html', {
                scope: $scope,
                animation: 'slide-in-up'
            }).then(function (modal) {
                $scope.modal = modal;
            });

            $scope.openModal = function (title, videos) {
                var video_paths = videos.map(function (video) {
                    return host + '/videos/' + video.path + 'raw/' + video.filename + '.mp4';
                });

                //Check the current cookie content
                var i = eStadium.checkCookie();
                if (i == 0){
                    //When the cookie does not match password, ask user to input password
                    $ionicPopup.prompt({
                        title: 'Enter the Password',
                        inputType: 'password',
                        inputPlaceholder: 'Please input your password (2016)'
                    }).then(function(res) {
                        console.log('Your password is', res);
                        eStadium.setCookie('password',res,1);
                        if (res == '2016') {
                            //Just show the video
                            $scope.play = true;
                            $scope.videoPlayerInfo = {
                                title: title,
                                videos_paths: video_paths
                            };
                            console.log("Show modal next.");
                            $scope.modal.show().then(function () {});
                        }
                        else if (res == undefined){
                            //Do nothing;close the popup
                            console.log("res == undefined")
                        }
                        else{
                            //Say you got your password wrong
                            console.log("Wrong password!");
                            $ionicPopup.alert({
                                title: 'Status',
                                template: 'Wrong password'
                            });
                        }
                    });
                }
                else
                {
                    //When cookie matches password, show the video
                    console.log("this is the else block");
                    $scope.videoPlayerInfo = {
                        title: title,
                        videos_paths: video_paths
                    };
                    $scope.modal.show().then(function () {});
                }
            };

            $scope.closeModal = function () {
                $scope.modal.hide();
            };
            $scope.$on('$destroy', function () {
                $scope.modal.remove();
            });

            // Load data
            eStadium.getPopularPlayData().then(function (data) {
                // Data from the service
                $scope.global_data = data.global_data;
                console.log($scope.global_data);
                $scope.data = data.data;
                console.log($scope.data);

                // Computed data for the view
                $scope.quarters = Object.keys($scope.data);
                console.log($scope.quarters);

                // Sanitize play type and add play type image to each play
                $scope.quarters.forEach(function (key) {
                    var plays = $scope.data[key];

                    plays.forEach(function (play, index) {
                        // Sanitize this play with correct play type
                        var sanitized_play = ObjectUtils.sanitizePlayType(play);

                        // Find the play type image path
                        sanitized_play.image_path = ObjectUtils.PLAY_TYPE_TO_IMAGE_PATH_MAPPING[sanitized_play.type];

                        // Replace old play with sanitized play
                        $scope.data[key][index] = sanitized_play;
                    })
                });

                // Current state of the view
                $scope.current_quarter = $scope.global_data.quarter == 'Q1' ? 1
                    : $scope.global_data.quarter == 'Q2' ? 2 : $scope.global_data.quarter == 'Q3' ? 3
                    : 4;
                $scope.per_tab_data = $scope.data[$scope.current_quarter];
                $scope.tabClicked = function (quarter) {
                    $scope.current_quarter = quarter;
                    $scope.per_tab_data = $scope.data[quarter];
                };
            }).catch(function (error) {
                console.error(error);
            })
        }

        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }])


    .controller('DriveTrackerCtrl', ['$scope', 'eStadium', 'host', function ($scope, eStadium, host) {
        function render() {
            eStadium.getAllDrives().then(function (data) {
                // Data from the service
                $scope.global_data = data.global_data;
                $scope.data = data.data;
                $scope.host = host;

                // Computed data for the view
                $scope.all_drives = $scope.data.map(function (item) {
                    return {
                        "drive_id": item.driveid,
                        "label": item.homeaway + item.index
                    };
                });

                // Current state of the view
                $scope.current_drive_index = $scope.all_drives.length - 1;
                $scope.current_drive = $scope.all_drives[$scope.current_drive_index];


                function loadCurrentDrive() {
                    eStadium.getDriveById($scope.all_drives[$scope.current_drive_index].drive_id).then(function (data) {
                        $scope.current_drive_image = host + data.image;
                        $scope.imageWidth = data.width;
                    }).catch(function (error) {
                        console.error(error)
                    });
                }

                $scope.optionClicked = function (drive) {
                    $scope.current_drive_index = drive;
                    $scope.current_drive = $scope.all_drives[drive];
                    loadCurrentDrive();
                };

                loadCurrentDrive();
            }).catch(function (error) {
                console.error(error);
            });
        }

        render();

        $scope.$on('refresh', function (event, args) {
            render();
        })
    }]);
