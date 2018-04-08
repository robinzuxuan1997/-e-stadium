<?
  $p->startTemplate();
  $total=0;
?>
     <script language="JavaScript" type="text/javascript">
       var sec = 00;   // set the seconds
       var min = <?=$min?>;   // set the minutes

       function countDown() {
         sec--;
         if (sec == -01) {
           sec = 59;
           min = min - 1; }
         else {
           min = min; }

         if (sec<=9) { sec = "0" + sec; }

         time = (min<=9 ? "0" + min : min) + " min and " + sec + " sec ";

         if (document.getElementById) { document.getElementById('theTime').innerHTML = time; }

         SD=window.setTimeout("countDown();", 1000);
         if (min == '00' && sec == '00') { sec = "00"; window.clearTimeout(SD); }
       }
       window.onload = countDown;
     </script>
<h1> Order # <?=$orderid?> </h1>
  <table>
  
  <?foreach($order as $o) {
      if($o[quantity] > 0) { ?>
        <tr><td>  <?=$o[name]?> </td>
        <td> $<?=$o[cost]?> </td>
        <td>  x <?=$o[quantity]?> </td> </tr>
     <? $total = $total + ($o[cost] * $o[quantity]);
      } 
    } ?>
  <tr><td colspan=3> <hr></td></tr>
 <tr><td> Total: </td>
     <td colspan=2 align=center>$<?=$total?></td></tr>
  </table>
  <br>
  <table width=100%>
    <tr><td width=100% style="font-size:100%">Time Left:    <span id="theTime" class="timeClass"></span></td></tr>
    <tr><td> Time Done <?=$end_time?> </tr></td>
  </table>
<br>
<a href="<?=$path->getWebPath("page_concessions")?>"> Back to Concessions </a>
<?
  $p->close();
?>
