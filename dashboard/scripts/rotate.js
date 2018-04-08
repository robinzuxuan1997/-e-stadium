
    var currentPage = 0;
    
    function startTime()
    {
	var today=new Date();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();
	// add a zero in front of numbers<10
	m=checkTime(m);
	s=checkTime(s);
	t=setInterval(function(){startTime()},5000);//10 sec
	if (currentPage == 0)
	{
	    document.getElementById('txt2').innerHTML="nothing";
	    document.getElementById('txt').innerHTML=h+":"+m+":"+s;
	    currentPage = 1;
	}
	else if(currentPage == 1)
	{
	    document.getElementById('txt2').innerHTML="its at 1 changed";
	    window.location.href = '#gamestats';
	    currentPage = 2;
	}
	else if(currentPage == 2)
	{
	    
	    document.getElementById('txt2').innerHTML="its at 2 changed";
	    window.location.href = '#scoring';
	    currentPage = 3;
	}
	else if(currentPage == 2)
	{
	    
	    document.getElementById('txt2').innerHTML="its at 3 changed";
	    window.location.href = '#teamstats';
	    currentPage = 1;
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
