<html>
  <head>
    <meta http-equiv="refresh" content="15"/>
    <? if ($play_quarter != $video_quarter) { ?>
      <script language="JavaScript">
      <!--
        x = 0;
        function changebg() {
          if (x % 2) {
            document.bgColor = "#FF0000";
          }
          else {
            document.bgColor = "#0000FF";
          }
          x++;
        }
        changebg();
        junk = setInterval("changebg()", 500);
      //-->
      </script>
    <?}?>
  </head>
  <body>
  <? if ($play_quarter != $video_quarter) {?>
  <marquee behavior="alternate" direction="up" width="90%" height="100%"> 
    <marquee direction="RIGHT OR LEFT" behavior="alternate">
  <?}?>
      <center>
        <table border="0"><tr><td>
          <h1>Play Quarter: </h1></td><td>
          <h1><?=$play_quarter?></h1></td></tr><tr><td>
    
          <h1>Video Quarter: </h1></td><td>
          <h1><?=$video_quarter?></h1></td></tr>
        </table>
    </center>
  <? if ($play_quarter != $video_quarter) {?>
    </marquee>
  </marquee>
  <?}?>
  </body>
</html>
