<DOCTYPE html> 

<html> 

<head> 

  <meta name=viewport content="user-scalable=no,width=device-width" />
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
        <script src="../js/main.js"></script>
        <script src="../js/map.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCuox9Kc5opHDAjapGHAlp7j1-fzP0eAFs&sensor=true"></script>

</head> 


<body> 


<div data-role=page id=home>

  <div data-role=header>

    <h1>Home</h1>

  </div>


  <div data-role=content>

    <span> Latitude : </span> <input type=text id=lat />

    <span> Longitude : </span> <input type=text id=lng />

    <a data-role=button id=btn>Display map</a>

  </div>

</div>


<div data-role=page id=win2 data-add-back-btn=true>

  <div data-role=header>

    <h1>Window 2</h1>

  </div>


  <div data-role=content>

  </div>

</div>


</body>

</html>


<script>


navigator.geolocation.getCurrentPosition (function (pos)

{

  var lat = pos.coords.latitude;

  var lng = pos.coords.longitude;

  $("#lat").val (lat);

  $("#lng").val (lng);

});


$("#btn").bind ("click", function (event)

{

  var lat = $("#lat").val ();

  var lng = $("#lng").val ();

  var latlng = new google.maps.LatLng (lat, lng);

  var options = { 

    zoom : 15, 

    center : latlng, 

    mapTypeId : google.maps.MapTypeId.ROADMAP 

  };

  var $content = $("#win2 div:jqmData(role=content)");

  $content.height (screen.height - 50);

  var map = new google.maps.Map ($content[0], options);

  $.mobile.changePage ($("#win2"));

  

  new google.maps.Marker ( 

  { 

    map : map, 

    animation : google.maps.Animation.DROP,

    position : latlng  

  });  

});


</script>

