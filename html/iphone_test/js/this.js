//
var jQT = new $.jQTouch({
    icon: 'images/estadIcon.jpg',
    startupScreen: 'images/backgroung.png',
    statusBar: 'black'
});

//javascript functions
$(function(){
    // Show a swipe event on swipe test
    $('#swipeme').swipe(function(evt, data) {
        $(this).html('You swiped <strong>' + data.direction + '</strong>!');
    });
    $('a[target="_blank"]').click(function() {
        if (confirm('This link opens in a new window.')) {
            return true;
        } else {
            $(this).removeClass('active');
            return false;
        }
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
    $('#stats').bind('pageAnimationEnd', function(e, info){
        $('#statscontentall',this).load('/mobile/archive/index.php?view=gamelist&gameid='+gameid+" #smartdevicescontent");
    });

    $('#gtplayerstats').bind('pageAnimationEnd', function(e, info){
       $("#gtplayerstats_content", this).load('/mobile/playerstats/index.php?gameid='+gameid+'&teamid='+homeid+' #content>table>table');
    });

    $('#vsplayerstats').bind('pageAnimationEnd', function(e, info){
        $('#vsplayerstats_content', this).load('/mobile/playerstats/index.php?gameid='+gameid+'&teamid='+awayid+' #content>table>table');
    });

    $('#gtcoachbios').bind('pageAnimationEnd', function(e, info){
        $('#gtcoachbios div#content').load('/mobile/bio/coach_iphone.php?teamid='+homeid);
    });

    $('#videos').bind('pageAnimationEnd', function(e, info){
        $('#videos div#videos_content').load('/mobile/videos/gamevids/videos.php');        
    });

    $('#drivetracker').bind('pageAnimationEnd', function(e, info){       
        $('#drivetrackercontent').load('../mobile/drvtrk/index.php #thiscontent');
    });

    $('#playbyplay').bind('pageAnimationEnd', function(e, info){      
        $('#playbyplaycontent').load('../mobile/playbyplay/playbyplay.php');
    });


    // Orientation callback event
    $('body').bind('turn', function(e, data){
        $('#orient').html('Orientation: ' + data.orientation);
    });
});
