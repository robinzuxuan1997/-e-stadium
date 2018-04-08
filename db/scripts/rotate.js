
    var currentPage = 0;
    var foobar = 0;
    var divs = $('div.dash-nav').children();
    
    function rotate()
    {
	//var today=new Date();
	//var h=today.getHours();
	//var m=today.getMinutes();
	//var s=today.getSeconds();
	//// add a zero in front of numbers<10
	//m=checkTime(m);
	//s=checkTime(s);
	//t=setInterval(function(){startTime()},5000);//10 sec
	if (currentPage == 0)
	{
	    //document.getElementById('txt2').innerHTML="nothing";
	    //document.getElementById('txt').innerHTML=h+":"+m+":"+s;
            $.mobile.changePage($("#scoring"), "slide", true, true);
	    currentPage = 1;
            $("#dash-nav li a:eq(0)").removeClass().addClass("dummy");
            //$("#dash-nav li a:eq(0)").addClass("dncp");
            $("#dash-nav li a:eq(1)").removeClass().addClass("dncp");
            //$("#dash-nav li a:eq(2)").addClass("dummy");
	}
	else if(currentPage == 1)
	{
	    $.mobile.changePage($("#teamstats"), "slide", true, true);
	    currentPage = 2;
            $("#dash-nav li a:eq(1)").removeClass().addClass("dummy");
            //$("#dash-nav li a:eq(1)").addClass("dncp");
            $("#dash-nav li a:eq(2)").removeClass().addClass("dncp");
            //$("#dash-nav li a:eq(0)").addClass("dummy");
	}
	else if(currentPage == 2)
	{
	    $.mobile.changePage($("#gamestats"), "slide", true, true);
	    currentPage = 0;
            $("#dash-nav li a:eq(2)").removeClass().addClass("dummy");
            //$("#dash-nav li a:eq(2)").addClass("dncp");
            $("#dash-nav li a:eq(0)").removeClass().addClass("dncp");
            //$("#dash-nav li a:eq(1)").addClass("dummy");
	}
    }
    
    function rotateTest()
    {
        //$('.slideTransition').live("swipeleft", function(){
        //        $.mobile.changePage("#foo", "slide", false, true);
        //    });
        //    $('.slideTransition').live("swiperight", function(){
        //        $.mobile.changePage("#bar", "slide", true, true);
        //    }); 
        
        //t=setInterval(function(){rotateTest()},5000);
        if (foobar == 0)
        {
            //function changePage( to, transition, back, changeHash)
            //transition true will cause reverse direction
            //transition (string, examples: "pop", "slide"," "none")
            //$("#about")
            $.mobile.changePage($("#bar"), "slide", false, true);
            foobar = 1;
        }
        else if (foobar ==1)
        {
            $.mobile.changePage($("#foo"), "slide", true, true);
            foobar = 0;
        }
    }

    function checkTime(i)
    {
        if (i<10)
	  {
	    i="0" + i;
	    }
	return i;
    }
