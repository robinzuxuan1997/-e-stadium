var myScroll;
var a = 0;
var b = 0;

var pages = [];
function loaded() {
	//setHeight();	// Set the wrapper height. Not strictly needed, see setHeight() function below.

	// Please note that the following is the only line needed by iScroll to work. Everything else here is to make this demo fancier.
	setTimeout(function(){init();},0);
}

function init(){
	//console.log(jQuery.widget);
	//console.log(jQuery.mobile.widget);
	
	//myScroll = new iScroll('scroller', {desktopCompatibility:true});
	//setTimeout(function () { myScroll.refresh(); }, 100);
	$.mobile.initializePage();
	
	console.log("set click event");
		console.log("event set");
	
	
	initPages();
	if (document.location.href.indexOf("dashboard") == -1)
	{
	initMenu();
	console.log("menu init~");
	}
	else
	{
		initLinks();
		updateLinks();
		// setup an event for the dashboard links
	}
	if (scroll!="no"){
    	$("[data-scroll]:not(.ui-scrollview-clip)").each(function(){
    		var $this = $(this);
    		// XXX: Remove this check for ui-scrolllistview once we've
    		//      integrated list divider support into the main scrollview class.
    		if ($this.hasClass("ui-scrolllistview"))
    			$this.scrolllistview();
    		else
    		{
    			var st = $this.data("scroll") + "";
    			var paging = st && st.search(/^[xy]p$/) != -1;
    			var dir = st && st.search(/^[xy]/) != -1 ? st.charAt(0) : null;
    
    			var opts = {};
    			if (dir)
    				opts.direction = dir;
    			if (paging)
    				opts.pagingEnabled = true;
    
    			var method = $this.data("scroll-method");
    			if (method)
    				opts.scrollMethod = method;
    
    			$this.scrollview(opts);
    		}
    	});
	}
	asyncInit();
}

function toggleMenu(){	
	$("#wrapper-footer").toggleClass("hidden");
	
	/*if ($("#menu-cont").hasClass("hidden")){
		console.log("javascript link");
		a = $("#menu a[href='javascript:']");
		
		
		a.attr("href",a.attr("disabledhref"));
		a.removeAttr("disabledhref");
		
		a = $("#menu a[href=#"+$.mobile.activePage.attr("id")+"]");
		a.attr("disabledhref",a.attr("href"));
		a.attr("href","javascript:");
	}
	
	$("#menu-cont").toggleClass("hidden");*/
	var ma = $("#menu-arrow");
	ma.toggleClass("arrow-n");
	ma.toggleClass("arrow-s");	
}

function initLinks()
{
	$("#dash-nav a").click(function(event){
		console.log("dash-nav a clicked: "+$(this).attr("href"));
		
		
		//$(this).attr("disabledhref",$(this).attr("href"));
		//$(this).attr("href","javascript:");
		/*
		$(this).removeClass("dummy");
		$(this).addClass("dncp");
		if ($(this).attr("href") == "homepage") 
		{
			a = $("#dash-nav a.offense");
			a.removeClass("dummy");
			a.removeClass("dncp");
		}
		if ($(this).attr("href") == "offense") 
		{
			a = $("#dash-nav a.homepage");
			a.removeClass("dummy");
			a.removeClass("dncp");
		}*/
		
		$('#dash-nav .dncp').addClass("dummy");
		$('#dash-nav .dncp').removeClass("dncp");
		
		$(this).removeClass("dummy");
		$(this).addClass("dncp");

		updateLinks();
	}
	);
}
function updateLinks(event)
{
	console.log("Updating links!");
	a = $("#dash-nav a[href='javascript:']");

		
	a.attr("href",a.attr("disabledhref"));
	//a.addClass("dummy");
	//a.removeClass("dncp");
	a.removeAttr("disabledhref");
	a = $("#dash-nav a[href=#"+$.mobile.activePage.attr("id")+"]");
	a.attr("disabledhref",a.attr("href"));
	a.attr("href","javascript:");
	//a.removeClass("dummy");
	//a.addClass("dncp");
}

function sizeMenu(){
	var wraph = $("#wrapper").height();
	var mh = $("#menu").height();
	console.log("wraph: "+wraph+" mh: "+mh);
	if (mh>wraph-20){
		$("#menu").height(wraph-20);
		mh = wraph-20;
	}
	
    /*$("#menu-cont").css("top",($("#footer").offset().top+
        $("#footer").height()+25)+"px");*/
	//$("#menu-cont").css("top",(
	//	$("#footer").offset().top-mh-25)+"px");
}
function menuClick(){
	console.log("clicked");
	
	toggleMenu();
	sizeMenu();
}
function initMenu(){
	//Set toggle for menu
	//$("#footer .footcenter").click(menuClick);
	
    $("#footer .foot-top-pages").click(menuClick);
    $("#footer .game-period").click(menuClick);
	
	$("#menu a").click(function(event){
		console.log("menu a clicked: "+$(this).attr("href"));
		
		toggleMenu();
		//if ($(this).attr("href").substring(1)==$.mobile.activePage.attr("id")){
		//	console.log("same page");
		//	
		//}
	});
	
	document.addEventListener('swipeleft', function (e) { 
		console.log("swipeleft");	
		alert("swiperight");
	}, false);
	document.addEventListener('swiperight', function (e) { 
		console.log("swiperight");	
		alert("swiperight");
	}, false);
}

function initPages(){
	//menu ul li a
	var pagesDiv = $(".page-list-indicators");
	

	if (document.location.href.indexOf("dashboard") == -1)
	{
		//$("#menu ul li a").each(function(){
		//	var page = $(this).attr("href").substring(1);
		//	pages.push(page);
		//
		//	pagesDiv.append(
		//	'<div class="page-indicator" data-page-id="'+page+'">o</div>'
		//	);
	//});
	//}
	//else
	//{
		$("#dash-nav ul li a").each(function(){
			var page = $(this).attr("href").substring(1);
			pages.push(page);
		
		pagesDiv.append(
			'<div class="page-indicator" data-page-id="'+page+'">o</div>'
			);
		
		});
		
		
		
	
	}	


	//console.log("current: "+$.mobile.activePage.attr("id"));
	//var currentpage = $.mobile.urlStack[$.mobile.urlStack.length-1].url;
	var currentpage = $.mobile.activePage.attr("id");
	updatePages(currentpage);
	
	$('body').live('pageshow',function(event, ui){
	  console.log(event.target.id);
	  var currentpage = event.target.id;
	  //Fixed bug: Homepage not showing after clicking Home on homepage
	  //the class ui-page-active sets homepage active, thus visible
	  //if (currentpage=="homepage") $.mobile.activePage.addClass('ui-page-active');
	  if (currentpage=="") currentpage="homepage";	  
	  updatePages(currentpage);
 
	});	
}

function updatePages(currentPage){
	$(".page-list-indicators .current-page").removeClass("current-page");
  	$(".page-list-indicators").children().each(function(){
  		if ($(this).attr("data-page-id")==currentPage){
  			$(this).addClass("current-page");

  		}	
  	});
 
  	for (var i=0;i<pages.length;i++){
  		if (pages[i]==currentPage){
  			var prevp = "#"+((i>0)?pages[i-1]:pages[pages.length-1]);
  			var nextp = "#"+((i<pages.length-1)?pages[i+1]:pages[0]);	
  			$(".goleft a").attr("href",prevp);
  			$(".goright a").attr("href",nextp);
  		}
  	}
  	
  	showPage(currentPage);
}
// Change wrapper height based on device orientation. Not strictly needed by iScroll, you may also use pure CSS techniques.
function setHeight() {
	var headerH = document.getElementById('header').offsetHeight,
		footerH = document.getElementById('footer').offsetHeight,
		wrapperH = window.innerHeight - headerH - footerH;
	document.getElementById('wrapper').style.height = wrapperH + 'px';
}

// Check screen size on orientation change
//window.addEventListener('onorientationchange' in window ? 'orientationchange' : 'resize', setHeight, false);

// Prevent the whole screen to scroll when dragging elements outside of the scroller (ie:header/footer).
// If you want to use iScroll in a portion of the screen and still be able to use the native scrolling, do *not* preventDefault on touchmove.
document.addEventListener('touchmove', function (e) { /*e.preventDefault();*/ }, false);

// Load iScroll when DOM content is ready.
document.addEventListener('DOMContentLoaded', loaded, false);
