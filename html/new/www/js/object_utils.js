angular.module('estadium.object_utils', []);

angular.module('estadium.object_utils').factory('ObjectUtils', function () {
    var factory = {};

    /**
     * Holds mapping:
     * from the play type
     * to the image path to the play type
     */
    factory.PLAY_TYPE_TO_IMAGE_PATH_MAPPING = {
        'K': 'img/types/kickoff.png',
        'X': 'img/types/fumble.png',
        'U': 'img/types/punt.png',
        'F': 'img/types/good_field_goal.png',
        'TD': 'img/types/touchdown.png',
        'R': 'img/types/rush.png',
        'P': 'img/types/complete_pass.png',
        'RushLoss': 'img/types/loss.png',
        'IncPass': 'img/types/incomplete_pass.png',
        'FGMiss' :'img/types/bad_field_goal.png'


    };



    /**
     * Holds mapping:
     * from the keyword to be detected in all cap (e.g. TOUCHDOWN)
     * to the proper play type (e.g. TD)
     */
    factory.PLAY_TYPE_SANITIZING_BLACKLIST = {
        'TOUCHDOWN': 'TD',
        'RUSH FOR LOSS': 'RushLoss',
        'PASS INCOMPLETE': 'IncPass',
        'KICK ATTEMPT FAILED': 'FGMiss',
        'MISSED' : 'FGMiss'
    };

    /**
     * List of play types that are certain to be valid
     */
    factory.PLAY_TYPE_SANITIZING_WHITELIST = [];

    factory.sanitizePlayType = function (play) {
        // If type of this play is one of the certain valid ones
        if (factory.PLAY_TYPE_SANITIZING_WHITELIST.indexOf(play.type) > -1) {
            return play;
        }
        else
        {
            var capitalized_text = play.text.toUpperCase();
            var sanitized_type = play.type;

            // Iterate each blacklist word
            var blacklist_words = Object.keys(factory.PLAY_TYPE_SANITIZING_BLACKLIST);
            blacklist_words.forEach(function (blacklist_word) {
                // If capitalized text contains this blacklist word
                if (capitalized_text.indexOf(blacklist_word) > -1) {
                    sanitized_type = factory.PLAY_TYPE_SANITIZING_BLACKLIST[blacklist_word];
                }
            });

            play.type = sanitized_type;
            return play;
        }
    };

    factory.convertTeamStats = function (data) {
        var converted = [];

        var setData = function (label, header, data) {
            converted.push({
                "label": label,
                "header": header,
                "data": data
            })
        };

        setData("First Downs", true, data['first_downs']);
        setData("Rushing", false, data['rush_fd']);
        setData("Passing", false, data['pass_fd']);
        setData("Penalty", false, data['penalty_fd']);
        setData("Net Yards Rushing", true, data['net_rush_yds']);
        setData("Rushing attempts", false, data['rush_att']);
        setData("Average Per Rush", false, data['rush_att']!=0?Math.round(data['net_rush_yds']*100 / data['rush_att'])/100:0);
        setData("Rushing Touchdowns", false, data['rush_td']);
        setData("Yards Gained Rushing", false, data['rush_gained']);
        setData("Yards Lost Rushing", false, data['rush_lost']);
        setData("Net Yards Passing", true, data['net_pass_yds']);
        setData("Completions-Attempts-Int", false, data['pass_comp'] + '-' + data['pass_att'] + '-' + data['pass_int']);
        setData("Average Per Attempt", false, data['pass_att']!=0?Math.round(data['net_pass_yds']*100 / data['pass_att'])/100:0);
        setData("Average Per Completion", false, data['pass_comp']!=0?Math.round(data['net_pass_yds']*100 / data['pass_comp'])/100:0);
        setData("Passing Touchdowns", false, data['pass_td']);
        setData("Total Offense Yards", true, data['tot_off_yds']);
        setData("Total Offense Plays", false, data['rush_att'] + data['pass_att']);
        setData("Average Gain Per Play", false, ((data['pass_att'] != 0)||(data['rush_att'] !=0))?Math.round( (data['net_rush_yds']+data['net_pass_yds'])*100 / (data['rush_att'] + data['pass_att']) )/100:0);
        setData("Fumbles: Number-Lost", true, data['fumble_cnt'] + '-' + data['fumble_lost']);
        setData("Penalties: Number-Yards", true, data['penalty_cnt'] + '-' + data['penalty_yds']);
        setData("Punts-Yards", true, data['punt_cnt'] + '-' + data['punt_yds']);
        setData("Average Yards Per Punt", false,  data['punt_cnt']!=0?Math.round(data['punt_yds']*100 / data['punt_cnt'])/100:0);
        setData("Inside 20", false, data['punt_in20']);
        setData("50+ Yards", false, data['punt_plus50']);
        setData("Touch-backs", false, data['punt_tb']);
        setData("Fair Catch", false, data['punt_fc']);
        setData("Kickoffs-Yards", true, data['kick_cnt'] + '-' + data['kick_yds']);
        setData("Average Yards Per Kickoff", false, data['kick_cnt']!=0?Math.round(data['kick_yds']*100 / data['kick_cnt'])/100:0);
        setData("Touch-backs", false, data['kick_tb']);
        setData("Punt Returns: Number-Yards-TD", true, data['punt_ret_cnt'] + '-' + data['punt_ret_yds'] + '-' + data['punt_ret_td']);
        setData("Average Per Return", false, data['punt_ret_cnt']!=0?Math.round(data['punt_ret_yds']*100 / data['punt_ret_cnt'])/100:0);
        setData("Kickoff Returns: Number-Yards-TD", true, data['kick_ret_cnt'] + '-' + data['kick_ret_yds'] + '-' + data['kick_ret_td']);
        setData("Average Per Return", false, data['kick_ret_cnt']!=0?Math.round(data['kick_ret_yds']*100 / data['kick_ret_cnt'])/100:0);
        setData("Interceptions: Number-Yards-TD", true, data['int_cnt'] + '-' + data['int_yds'] + '-' + data['int_td']);
        setData("Fumble Returns: Number-Yards-TD", true, data['fumble_ret_cnt'] + '-' + data['fumble_ret_yds'] + '-' + data['fumble_ret_td']);
        setData("Miscellaneous Yards", true, data['misc_yds']);
        setData("Possession Time", true, data['top']);
        setData("Third Down Conversions", true, data['third_conv'] + ' of ' + data['third_att']);
        setData("Fourth Down Conversions",true,  data['fourth_conv'] + ' of ' + data['fourth_att']);
        setData("Red Zone Scores-Chances", true, data['rz_conv'] + ' of ' + data['rz_att']);
        setData("Sacks By: Number-Yards", true, data['sacksby_cnt'] + ' of ' + data['sacksby_yds']);
        setData("PAT Kicks", true, data['pat_conv'] + ' of ' + data['pat_att']);
        setData("Field Goals", true, data['fg_conv'] + ' of ' + data['fg_att']);

        return converted;
    };

    return factory;
});
