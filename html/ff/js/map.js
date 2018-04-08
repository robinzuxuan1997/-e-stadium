function loadMapChangePage(){
  var options = { 
    zoom : 15, 
    mapTypeId : google.maps.MapTypeId.ROADMAP 
  };
  var $content = $("#main div:jqmData(role=content)");
  $content.height (screen.height - 50);
  var map = new google.maps.Map ($content[0], options);
  $.mobile.changePage ($("#main"));
  new google.maps.Marker ( 
  { 
    map : map, 
    animation : google.maps.Animation.DROP,
  });  
}
