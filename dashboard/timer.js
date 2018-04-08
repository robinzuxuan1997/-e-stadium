var swCycleTime=50; //run cycle every 50ms?

// Functional Code

var sw,swObj,swct,swnow,swcycle; //create some variables, we'll figure out what they are soon 
var swObjAry=new Array(); //and i assume that for every stopwatch on the page an object is created and this is the container array

//ok so you click the button which would onclick="swstart($divname,+);" the plus is for count upwards, you can - it 
function swStart(id,ud)
{ 
    swObj=document.getElementById(id); //so the swobj var is your actual div by the look of it 
    swct=swObj.innerHTML.split(':'); //and it splits the time into minutes, seconds, milliseconds into an array 

    swnow=new Date(); //this is the time the button got clicked 
    swObj.now=swnow.getTime(); //and it fires that variable into swobj's now value 
    swObj.reset=swObj.innerHTML; //it takes a note of whats in the div so that when you reset, it puts the initial value back in 
    swObj.ud=ud; //the stopwatch object is told wether to count up or down 
    
    //if the initial value turns out to be a string, 
    if (!isNaN(swObj.innerHTML))
    { 
        swObj.time=parseInt(swObj.innerHTML); //parse it to an int 
    }
    //otherwise if our split is 4 long, for hours! 
    else if (swct.length==4)
    { 
        swObj.time=(swct[0]*1000*60)+(swct[1]*1000*60)+(swct[2]*1000)+parseInt(swct[3]); //the stopwatches time so far is mins + secs +ms (total being in ms) 
    }
    //otherwise if our split is 3 long 
    else if (swct.length==3)
    { 
        swObj.time=(swct[0]*1000*60)+(swct[1]*1000)+parseInt(swct[2]); //the stopwatches time so far is mins + secs +ms (total being in ms) 
    }
    //or if its just seconds and milliseconds 
    else if (swct.length==2)
    { 
        swObj.time=(swct[0]*1000)+parseInt(swct[1]); 
    }
    //or just milliseconds 
    else if (swct.length==1)
    { 
        swObj.time=parseInt(swct[1]); 
    } 
    
    //if it has only just started at 0 
    if (!swObj.time)
    { 
        swObj.time=1; //give it a millisecond to get it started 
    } 

    //if there isnt a c value (whatever c is :-P ) 
    if (!swObj.c)
    { 
        swObj.c=ud; //then make it + or -, whatever ud was 
        swObjAry[swObjAry.length]=swObj; //i dont get this - make the number of stopwatches = swobj, the div? :-s 
    } 
}

function swStop(id){ //anyway, so if you click the stop button (onclick="swstop($divname)"), 
swObj=document.getElementById(id); //get the stopwatch div name 
if (!swObj.time){ return; } //if there is no time variable, its already stopped. coolio. 
swObj.time=null; //get rid of the time value 
sw=new Date().getTime(); //this next bit will have to do with when you resume i suppose 
swObj.cycle+=(sw-swcycle); 
if (swObj.ud=='-'){ 
swObj.cycle-=(sw-swcycle); 
if (swObj.cycle<0){ swObj.cycle=0; } 
} 
swObj.innerHTML=/*(parseInt(swObj.cycle/1000/60/60)%60)+':'+*/(parseInt(swObj.cycle/1000/60)%60)+':'+((parseInt((swObj.cycle)/1000)%60)+':'+(parseInt(swObjAry[sw0].cycle%1000/10))); 
//display the time you stopped on, i added an extra bit here hor the hour 
}

//and this will be the running cylce then 
function swCycle()
{ 
    swcycle=new Date().getTime(); 
    for (sw0=0;sw0<swObjAry.length;sw0++)
    { 
        if (swObjAry[sw0].time)
        { 
            swObjAry[sw0].cycle=swObjAry[sw0].time+(swcycle-swObjAry[sw0].now); 
            if (swObjAry[sw0].ud=='-')
            { 
                swObjAry[sw0].cycle=swObjAry[sw0].time-(swcycle-swObjAry[sw0].now); 
                if (swObjAry[sw0].cycle<0)
                {
                    swObjAry[sw0].cycle=0; swObjAry[sw0].time=0;
                } 
            } 
            swObjAry[sw0].innerHTML=(parseInt(swObjAry[sw0].cycle/1000/60)%60)+':'+((parseInt((swObjAry[sw0].cycle)/1000)%60)); //added an hour bit here too +':'+(parseInt(swObjAry[sw0].cycle%1000/100))
        } 
    } 
}

function swReset(id,dt)
{ 
    swObj=document.getElementById(id); 
    swObj.innerHTML=swObj.reset; 
    swObj.time=null; 
}

setInterval('swCycle()',swCycleTime);
