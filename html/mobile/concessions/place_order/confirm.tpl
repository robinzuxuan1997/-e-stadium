<?
  $p->startTemplate();
  $p->setDisplayMode("form");
  $total = 0;
?>

<h1> Confirm your Order </h1>
<table> 
<form>
  <? foreach($food as $f) {
    if($f[quantity] > 0) { ?>
    <tr><td> <?=$f[name]?></td>
        <td> <? echo "$".$f[cost];?></td>
        <td>x <?=$f[quantity]?> </td></tr>
        <? $total = $total + ($f[cost] * $f[quantity]);?>
    <?}?>
  <?}?>
  <? foreach ($drink as $d) {
    if($d[quantity] > 0) { ?>
      <tr><td> <?=$d[name]?> </td>
          <td> $<?=$d[cost]?> </td>
          <td> x <?=$d[quantity]?> </td></tr>
        <? $total = $total = ($d[cost] * $d[quantity]); ?>
    <?}?>
  <?}?>
  <tr><td colspan=3> <hr></td></tr>
 <tr><td> Total: </td>
     <td colspan=2 align=center>$<?=$total?></td></tr>
 <tr> <td>
  <?$p->displayVar("place");?>
  <?$p->displayVar("view");?>
  <?$p->displayVar("orderid");?>
  </tr></td>
</form>
</table>
<a href="<?=$path->getWebPath("page_concessions");?>"> Cancel </a>  

<?
  $p->close();
?>
