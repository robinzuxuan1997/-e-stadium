<?
  $p->startTemplate();
?>
<h1> Orders </h1>
 <table border=0 cellpadding=5 width=100%> <tr align=center><td align=center style="font-size:150%"> 
   Order # </td> <td align=center style="font-size:150%"> 
   Order </td><td align=center style = "font-size:150%"> 
   Username </td><td align=center style = "font-size:150%">
   Time </td></tr>
 </table> 
 <form action="<?=$p->pagename();?>" method=POST>
  <?foreach($all_orders as $o) {?>
      <table width=100% border=0 cellpadding=5>  <tr align=center>
      <td style="font-size:100%" align=center> <a href="<?=$path->getPath("page_admin_concessions_order_status")?>?orderid=<?=$o[orderid]?>"> <?=$o[orderid]?> </a></td>
      <td style = "font-size:100%" align=center>
  <?foreach($o[order] as $f) { ?>
            <?=$f[quantity]?>      <?=$f[name]?><br>
    <?}?>
           </td>
            <td style="font-size:100%" align=center>  <?=$o[username]?> </td>
            <td align=center style="font-size:100%" > 

                <script language="JavaScript" type="text/javascript">
                  var sec = 00;   // set the seconds
                  var min = <?=$o[min]?>;   // set the minutes

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


                 <table width="100%">
                   <tr><td width="100%" align="center" style="font-size:100%"><span id="theTime" class="timeClass"></span></td></tr>
                 </table>
                 </td>
                 <td> <a href="<?=$p->pagename()?>?done=<?=$o[orderid]?>"> Done</a>
            </td></tr>
        </table>
        <hr>
    <?} ?>
  </table>
<?$p->displayVar("view")?>
</form>
<br>
<?
  $p->close();
?>
