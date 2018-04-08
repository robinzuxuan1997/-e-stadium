angular.module('estadium.services', []);

angular.module('estadium.services').factory('eStadium', ['$http', '$q', 'host', function ($http, $q, host) {

    var factory = {};

    var init = true;
    var ongoing_game_id = null;
    var current_game_id = null;

    var global_data = null;
    var scoring_summary_data = null;
    var team_stats_data = null;
    var play_by_play_data = null;
    var popular_play_data = null;
    var all_drives_data = null;
    var player_stats_data = null;

    factory.nullifyAllData = function () {
        global_data = null;
        scoring_summary_data = null;
        team_stats_data = null;
        play_by_play_data = null;
        popular_play_data = null;
        all_drives_data = null;
        player_stats_data = null;
    };

    /**
     * If you are switching to another game
     * Then change the current game id so that getGameGeneralInfo cna read the info for the new game
     * And then nullify all cached data
     * Notice you still need to manually make all the UI's refresh to get new data
     */
    factory.switchCurrentGame = function (new_game_id) {
        current_game_id = new_game_id;
        factory.nullifyAllData();
    };

    /**
     * This is basically a wrapper over switchCurrentGame, only with on going game id
     */
    factory.revertBackToOngoingGame = function () {
        factory.switchCurrentGame(ongoing_game_id);
    };

    /**
     * Following 3 factory functions are related to creating password prompt window on homepage and playbyplay.
     */
    factory.setCookie = function(cname,cvalue,exdays){
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname+"="+cvalue+"; "+expires;
    };


    factory.getCookie = function(cname){
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };


    factory.checkCookie= function(){
        var theCookie = factory.getCookie('password');
        if (theCookie != "2016")
        {
            return 0;
        }
        else
        {
            return 1;
        }
    };


    factory.getGlobalData = function () {
        var deferred = $q.defer();

        /**
         * It's a nasty asynchronous constructor
         * If initializing,
         * Always get the ongoing game id
         * So that later even if current game id is changed to a history game id
         * It can still revert back to the ongoing game id
         * Current game id is there to be transparently read by getGameGeneralInfo
         * And it always represents the game id that is currently displaying in the app
         */
        if (init) {
            $http.get(host + '/service/get/global/getGameId.php')
                .success(function (data) {
                    ongoing_game_id = data.gameId;
                    current_game_id = ongoing_game_id;
                    init = false;
                    internal_get_global_data();

                })
        }
        else {
            internal_get_global_data();
        }

        function internal_get_global_data() {
            if (global_data != null) {
                deferred.resolve(global_data);
            } else {
                $http.get(
                    host + '/service/get/global/getGameGeneralInfo.php',
                    {params: {"gameid": current_game_id}}
                )
                    .then(retrieve_general_info_data)
                    .then(retrieve_status_data)
                    .then(retrieve_score_board_data)
                    .catch(error_out);
            }

            var temp_general_info_data = null;

            function retrieve_general_info_data(result) {
                temp_general_info_data = result.data;
                return $http.get(
                    host + '/service/get/global/getGameStatus.php',
                    {params: {"gameid": temp_general_info_data.gameId}}
                );

            }

            var temp_status_data = null;

            function retrieve_status_data(result) {
                temp_status_data = result.data;
                return $http.get(
                    host + '/service/get/global/getGameScoreBoardData.php',
                    {params: {"gameid": temp_general_info_data.gameId}}
                );
            }

            function retrieve_score_board_data(result) {
                //commented code is for the XML files, not 100% working right now
                var scoreboard_data = result.data;
                //var xml = loadXMLDoc(host + '/scripts/stats_import/gamedata/clem_7.xml');
                //var teams = xml.getElementsByTagName("team");
                global_data = {
                    "game_id": temp_general_info_data.gameId,
                    "home_id": temp_general_info_data.homeId,
                    "home_name": temp_general_info_data.homeName,
                    "home_acronym": temp_general_info_data.homeAcronym,
                    "away_id": temp_general_info_data.visitorId,
                    "away_name": temp_general_info_data.visitorName,
                    "away_acronym": temp_general_info_data.visitorAcronym,
                    "home_logo_path": host + temp_general_info_data.homeLogoPath,
                    "away_logo_path": host + temp_general_info_data.visitorLogoPath,
                    "home_score": scoreboard_data.homeData.total,
                    "away_score": scoreboard_data.visitorData.total,
                    "quarter": "Q" + scoreboard_data.quarter,
                    "home_quarter_scores": {
                        "Q1": scoreboard_data.homeData.firstQ,
                        "Q2": scoreboard_data.homeData.secondQ,
                        "Q3": scoreboard_data.homeData.thirdQ,
                        "Q4": scoreboard_data.homeData.fourthQ,
                        "OverQ": scoreboard_data.homeData.overQ
                    },
                    "away_quarter_scores": {
                        "Q1": scoreboard_data.visitorData.firstQ,
                        "Q2": scoreboard_data.visitorData.secondQ,
                        "Q3": scoreboard_data.visitorData.thirdQ,
                        "Q4": scoreboard_data.visitorData.fourthQ,
                        "OverQ": scoreboard_data.visitorData.overQ
                    },
                    "home_ball_possession": temp_status_data.homeHasBall,
                    "time_left": temp_status_data.time,
                    "show_ball": true
                    //"gt_record": teams[0].getAttribute("record"),
                    //"gt_rank": teams[0].getAttribute("rank"),
                    //"away_record": teams[1].getAttribute("record"),
                    // "away_rank": teams[1].getAttribute("rank")
                };
                if (temp_status_data.time == '-') {
                    global_data.quarter = "Final";
                    global_data.show_ball = false;
                }
                //alert(teams[1].getAttribute("rank"));
                //xml function, not being used right now
                function loadXMLDoc (dname) {
                    var xmlDoc;
                    try {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.open('GET', dname, false);
                        xmlhttp.setRequestHeader('Content-Type', 'text/xml');
                        xmlhttp.send('');
                        xmlDoc = xmlhttp.responseXML;
                    } catch (e) {
                        try {
                            xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                        } catch (e) {
                            console.error(e.message);
                        }
                    }
                    return xmlDoc;
                }

                deferred.resolve(global_data);
            }

            function error_out(data, status) {
                deferred.reject(status);
            }
        }

        return deferred.promise;
    };

    factory.getScoringSummary = function () {
        var deferred = $q.defer();

        if (scoring_summary_data != null) {
            deferred.resolve(scoring_summary_data);

        } else {

            factory.getGlobalData()
                .then(retrieve_global_data)
                .then(retrieve_scoring_summary)
                .catch(error_out);
        }

        function retrieve_global_data(global_data) {
            return $http.get(
                host + '/service/get/global/drive_summary.php',
                {params: {"gameid": global_data.game_id}}
            );
        }

        function retrieve_scoring_summary(result) {
            var data = result.data;
            scoring_summary_data = {
                "global_data": global_data,
                "data": data
            };
            deferred.resolve(scoring_summary_data);
        }

        function error_out(data, status) {
            deferred.reject(status);
        }

        return deferred.promise;
    };

    factory.getTeamStatsData = function () {
        var deferred = $q.defer();

        if (team_stats_data != null) {
            deferred.resolve(team_stats_data);
        } else {
            factory.getGlobalData()
                .then(retrieve_global_data)
                .then(retrieve_team_stats_data)
                .catch(error_out);
        }

        function retrieve_global_data(global_data) {
            var home_stats_promise = $http.get(
                host + '/service/get/dashboard/teamstats.php',
                {params: {"gameid": global_data.game_id, "teamid": global_data.home_id}}
            );
            var away_stats_promise = $http.get(
                host + '/service/get/dashboard/teamstats.php',
                {params: {"gameid": global_data.game_id, "teamid": global_data.away_id}}
            );

            return $q.all([home_stats_promise, away_stats_promise]);
        }

        function retrieve_team_stats_data(result) {
            team_stats_data = {
                "global_data": global_data,
                "data": {
                    "home_stats": result[0].data,
                    "away_stats": result[1].data
                }
            };
            deferred.resolve(team_stats_data);
        }

        function error_out(data, status) {
            deferred.reject(status);
        }

        return deferred.promise;
    };

    factory.getPlayByPlayData = function () {
        var deferred = $q.defer();

        if (play_by_play_data != null) {
            deferred.resolve(play_by_play_data);
        } else {
            factory.getGlobalData()
                .then(retrieve_global_data)
                .then(retrieve_play_by_play_data)
                .catch(error_out);
        }

        function retrieve_global_data(global_data) {
            var promises = [];
            for (var q = 1; q < 5; ++q) {
                promises.push($http.get(
                    host + '/service/get/playbyplay/getPlaysByGameIdQuarter.php',
                    {params: {"gameid": global_data.game_id, "quarter": q}}
                ));
            }
            return $q.all(promises);
        }

        function retrieve_play_by_play_data(result) {
            var data = {};
            result.forEach(function (item) {
                data[item.config.params.quarter] = item.data;
            });
            play_by_play_data = {
                "global_data": global_data,
                "data": data
            };
            deferred.resolve(play_by_play_data);
        }

        function error_out(data, status) {
            deferred.reject(status);
        }

        return deferred.promise;
    };



    factory.getPopularPlayData = function () {
        var deferred = $q.defer();

        if (popular_play_data != null) {
            deferred.resolve(popular_play_data);
        } else {
            factory.getGlobalData()
                .then(retrieve_global_data)
                .then(retrieve_popular_play_data)
                .catch(error_out);
        }

        function retrieve_global_data(global_data) {
            var promises = [];
            for (var q = 1; q < 5; ++q) {
                promises.push($http.get(
                    host + '/service/get/popularplay/getPlaysByGameIdQuarterEnergy.php',
                    {params: {"gameid": global_data.game_id, "quarter": q}}
                ));
            }
            return $q.all(promises);
        }

        function retrieve_popular_play_data(result) {
            var data = {};
            result.forEach(function (item) {
                data[item.config.params.quarter] = item.data;
            });
            popular_play_data = {
                "global_data": global_data,
                "data": data
            };
            deferred.resolve(popular_play_data);
        }

        function error_out(data, status) {
            deferred.reject(status);
        }

        return deferred.promise;
    };

    factory.getAllDrives = function () {
        var deferred = $q.defer();

        if (all_drives_data != null) {
            deferred.resolve(all_drives_data);
        } else {
            factory.getGlobalData()
                .then(retrieve_global_data)
                .then(retrieve_all_drives_data)
                .catch(error_out);
        }

        function retrieve_global_data(global_data) {
            return $http.get(
                host + '/service/get/drivetracker/getDrivesAll.php',
                {params: {"gameid": global_data.game_id}}
            );
        }

        function retrieve_all_drives_data(result) {
            var data = result.data;
            all_drives_data = {
                "global_data": global_data,
                "data": data.drives
            };
            deferred.resolve(all_drives_data);
        }

        function error_out(data, status) {
            deferred.reject(status);
        }

        return deferred.promise;
    };

    factory.getDriveById = function (drive_id) {
        var deferred = $q.defer();

        factory.getGlobalData()
            .then(retrieve_global_data)
            .then(retrieve_drive_data)
            .catch(error_out);

        function retrieve_global_data(global_data) {
            return $http.get(
                host + '/service/get/drivetracker/getCurrent.php',
                {params: {"gameid": global_data.game_id, "driveid": drive_id}}
            );
        }

        function retrieve_drive_data(result) {
            deferred.resolve(result.data);
        }

        function error_out(data, status) {
            deferred.reject(status);
        }

        return deferred.promise;
    };

    factory.getPlayerStats = function () {
        var deferred = $q.defer();

        if (player_stats_data != null) {
            deferred.resolve(player_stats_data)
        } else {
            factory.getGlobalData()
                .then(retrieve_global_data)
                .then(retrieve_player_stats)
                .catch(error_out);
        }

        function retrieve_global_data(global_data) {
            var home_stats_promise = $http.get(
                host + '/service/get/stats/getPlayerStats.php',
                {params: {"gameid": global_data.game_id, "teamid": global_data.home_id}}
            );
            var away_stats_promise = $http.get(
                host + '/service/get/stats/getPlayerStats.php',
                {params: {"gameid": global_data.game_id, "teamid": global_data.away_id}}
            );

            return $q.all([home_stats_promise, away_stats_promise]);
        }

        function retrieve_player_stats(result) {
            var home_data = result[0].data;
            var away_data = result[1].data;

            player_stats_data = {
                "global_data": global_data,
                "data": {
                    "home_stats": home_data,
                    "away_stats": away_data,
                    "home_passing": home_data.passers,
                    "home_rushing": home_data.rushers,
                    "home_receiving": home_data.receivers,
                    "away_passing": away_data.passers,
                    "away_rushing": away_data.rushers,
                    "away_receiving": away_data.receivers,

                    "home_defense": home_data.defense,
                    "away_defense": away_data.defense,

                    "home_punting": home_data.punters,
                    "home_returns": home_data.allreturns,
                    "home_FGA": home_data.kickers,
                    "home_kickoffs": home_data.kickoffers,

                    "away_punting": away_data.punters,
                    "away_returns": away_data.allreturns,
                    "away_FGA": away_data.kickers,
                    "away_kickoffs": away_data.kickoffers
                }
            };
            deferred.resolve(player_stats_data);
        }

        function error_out(data, status) {
            deferred.reject(status);
        }



        return deferred.promise;
    };


    return factory;
}]);
