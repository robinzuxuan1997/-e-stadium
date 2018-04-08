//
var jQT = new $.jQTouch({
    icon: 'images/estadIcon.jpg',
    startupScreen: 'images/backgroung.png',
    statusBar: 'black'
});

//javascript functions
$(function(){

//    $('a img').click(function(){
//            link = $(this).attr("href");
//
//            $('#drivetrackercontent').load(link+' #thiscontent');
//            return false;
//     });

     
    // Show a swipe event on swipe test
    $('#swipeme').swipe(function(evt, data) {
        $(this).html('You swiped <strong>' + data.direction + '</strong>!');
    });
    
    // Page animation callback events
    $('#pageevents').
    bind('pageAnimationStart', function(e, info){
        $(this).find('.info').append('Started animating ' + info.direction + '&hellip; ');
    }).
    bind('pageAnimationEnd', function(e, info){
        $(this).find('.info').append(' finished animating ' + info.direction + '.<br /><br />');
    });

    //save the video type preference of the user
    $('#saveVideoSettings').bind('click', function(){
        //var selection = $('input[name=videotype]:checked').value();
        //alert('New video ' + selection +' saved');
        window.alert('Selection: ' + $('input[name=videotype]:checked').val());
    });
    
    // Page animations end with AJAX callback event, example 1 (load remote HTML only first time)
    $('#statspage').bind('pageAnimationEnd', function(e, info){
        loadStats();
    });

    $('#gtplayerstats').bind('pageAnimationEnd', function(e, info){
        $("#gtplayerstats_content", this).load('/mobile/playerstats/index.php?gameid='+gameId+'&teamid='+homeId+ ' #content');
    });

    $('#vsplayerstats').bind('pageAnimationEnd', function(e, info){
        $("#vsplayerstats_content", this).load('/mobile/playerstats/index.php?gameid='+gameId+'&teamid='+visitorId+ ' #content');
    });

    $('#videos').bind('pageAnimationEnd', function(e, info){
        loadVideosQuarter(currentQuarter);
    });

    $('#drivetracker').bind('pageAnimationEnd', function(e, info){       
        $('#drivetrackercontent').load('../mobile/drvtrk/index.php #thiscontent');
    });

    $('#playbyplay').bind('pageAnimationEnd', function(e, info){      
        loadPlayByPlay(currentQuarter);
    });

    $('#otherscores').bind('pageAnimationEnd', function(e, info){
        setUpOtherGames();
    });

    $('#weather').bind('pageAnimationEnd', function(e, info){
        loadWeather();
    });


    // Orientation callback event
    $('body').bind('turn', function(e, data){
        $('#orient').html('Orientation: ' + data.orientation);
    });


    $(document).ready(function(){

        $('#drivetrackercontent').load('/mobile/drvtrk/index.php #thiscontent').ajaxComplete(function(){
            loadLinksContent();
        });

        loadLinksContent();

    });

function hideExtraInWeather(){
    var x = $("#weathercontent center:eq(2)");
    x.hide();
}

 function loadLinksContent(){
        $('#drivetrackercontent a').click(function(){
            link = $(this).attr("href");

            $('#drivetrackercontent').load(link+' #thiscontent');
            return false;
        });
    }
});

weatherIsLoaded = false;

function refreshWeather(){
    weatherIsLoaded = false;
    setTimeout('loadWeather', 60000);
}

function loadWeather(){
    if(weatherIsLoaded)
        return;

    weatherIsLoaded = true;
    //The parameters to pass to xhrGet, the url, how to handle it, and the callbacks.
    var xhrArgs = {
        url: "http://estadium.gatech.edu/mobile/weather/index.php",
        handleAs: "text",
        load: function(data) {
            dojo.byId("weathercontent").innerHTML = data;
            dojo.byId("weathercontent").innerHTML = $("#weathercontent #content").html();
            var x = $("#weathercontent center:eq(1)");
            x.hide();
            var y = $('#weathercontent center:eq(2) center:eq(1)');
            y.hide();
            refreshWeather();
        },
        error: function(error) {
            console.log("An unexpected error occurred: " + error);
        }
    }

    //Call the asynchronous xhrGet
    var deferred = dojo.xhrGet(xhrArgs);
}



var lastVideoQuarterLoaded = -1;

function loadVideosQuarter(i){
    if(lastVideoQuarterLoaded == i)
        return;
    
    lastVideoQuarterLoaded = i;
    //The parameters to pass to xhrGet, the url, how to handle it, and the callbacks.
    var xhrArgs = {
        url: "http://estadium.gatech.edu/service/get/videos/getApprovedVideosByQuarterGameId.php",
        handleAs: "json",
        content: {
            gameid:gameId,
            quarter:i
        },
        load: function(data) {

            var t = 'Overtime';
            if(lastVideoQuarterLoaded < 5)
                t = lastVideoQuarterLoaded;
                    
            dojo.query('.viewing_current_quarter').forEach(function(e){
                e.innerHTML = t;
            })
            var text = "";
            
            for(var i=0;i<currentQuarter;i++){
                if(i + 1 != lastVideoQuarterLoaded){
                    if(i < 4)
                        text += '<li onclick=loadVideosQuarter(' + (i+1) + ')>Quarter' + (i+1) + '</li>';
                    else
                        text += '<li onclick=loadVideosQuarter(' + (i+1) + ')>Overtime</li>';
                }
                
            }

            dojo.query("#video_list_links").forEach(function(e){
                e.innerHTML = text;
            });

            var text2 = '<tr><th>&nbsp;Angle&nbsp;</th><th>Description</th></tr>';

            for(var i in data){
                d = data[i][0];
                text2 += ' <tr><td><a href="http://estadium.gatech.edu/videos/'+d['path']+'small_mp4/'+d['filename']+'.mp4" target="_blank"><img alt="" src="images/video_Icon.png"/>'+ d['anglenumber'] +'</a></td>\n\
                                <td>'+d['text']+'</td></tr>';
            }

            dojo.query("#list_of_videos").forEach(function(e){
                e.innerHTML = text2;
            });
        },
        error: function(error) {
            console.log("An unexpected error occurred: " + error);
        }
    }

    //Call the asynchronous xhrGet
    var deferred = dojo.xhrGet(xhrArgs);
}

var lastPBPQuarterLoaded = -1;
function loadPlayByPlay(i){

    if(lastPBPQuarterLoaded == i)
        return;

    lastPBPQuarterLoaded = i;
    //The parameters to pass to xhrGet, the url, how to handle it, and the callbacks.
    var xhrArgs = {
        url: "http://estadium.gatech.edu/service/get/playbyplay/getPlaysByGameIdQuarter.php",
        handleAs: "json",
        content: {
            gameid:gameId,
            quarter:i
        },
        load: function(data) {

            var t = 'Overtime';
            if(lastPBPQuarterLoaded < 5)
                t = lastPBPQuarterLoaded;

            dojo.query('.viewing_current_quarter').forEach(function(e){
                e.innerHTML = t;
            })
            var text = "";

            for(var i=0;i<currentQuarter;i++){
                if(i + 1 != lastPBPQuarterLoaded){
                    if(i < 4)
                        text += '<li onclick=loadPlayByPlay(' + (i+1) + ')>Quarter' + (i+1) + '</li>';
                    else
                        text += '<li onclick=loadPlayByPlay(' + (i+1) + ')>Overtime</li>';
                }

            }

            dojo.query("#play_list_links").forEach(function(e){
                e.innerHTML = text;
            });

            var text2 = "";
           dojo.forEach(data, function(d){
                text2 += ' <tr><td>'+d['text']+'</td></tr>';
            });

            dojo.query("#list_of_plays").forEach(function(e){
                e.innerHTML = text2;
            });
        },
        error: function(error) {
            console.log("An unexpected error occurred: " + error);
        }
    }

    //Call the asynchronous xhrGet
    var deferred = dojo.xhrGet(xhrArgs);
}

function loadStats(){
    //The parameters to pass to xhrGet, the url, how to handle it, and the callbacks.
    var xhrArgs = {
        url: "http://estadium.gatech.edu/mobile/archive/index.php",
        handleAs: "text",
        content: {
            gameid:gameId,
            view:'gamelist',
            smartdevices:1
        },
        load: function(data) {
            $('#statscontentall').html(data);
        },
        error: function(error) {
            console.log("An unexpected error occurred: " + error);
        }
    }

    //Call the asynchronous xhrGet
    var deferred = dojo.xhrGet(xhrArgs);
}

function loadOtherGamesData(form){
        var xhrArgs = {
        url: "http://estadium.gatech.edu/mobile/other_stats/index.php",
        handleAs: "text",
        content: {
            scores:form.value
        },
        load: function(data) {
            $('#otherscorescontent').html(data);
            $('#otherscorescontent').html($('#otherscorescontent #content').html());
            $("#otherscorescontent form").html(myListForm);
            $('#otherscorescontent div center').hide();
        },
        error: function(error) {
            console.log("An unexpected error occurred: " + error);
        }
    }

    //Call the asynchronous xhrGet
    var deferred = dojo.xhrPost(xhrArgs);
}

var myListForm = "";

function setUpOtherGames(){
    //The parameters to pass to xhrGet, the url, how to handle it, and the callbacks.
    var xhrArgs = {
        url: "http://estadium.gatech.edu/service/get/otherscores/getOtherScoresTitles.php",
        handleAs: "json",
        load: function(data) {
            myListForm = '<br><br><form method="post" name="Score"><select name="scores" onchange="loadOtherGamesData(this);">\n\
                        <option value="dummy">Please Select</option>';
            for(var row in data){
                myListForm += '<option value="' + row + '">' + data[row] + '</option>'
            }

            myListForm += "</select></form>";
            
            $('#otherscorescontent').html(myListForm);
            myListForm = $('#otherscorescontent form').html();
        },
        error: function(error) {
            console.log("An unexpected error occurred: " + error);
        }
    }

    //Call the asynchronous xhrGet
    var deferred = dojo.xhrGet(xhrArgs);
}
