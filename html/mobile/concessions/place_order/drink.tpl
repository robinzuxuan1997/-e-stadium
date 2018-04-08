<?
  $p->startTemplate();
  $p->setDisplayMode("form");
?>

<h1> Place a New Order </h1>
 <strong> Location: <?=$stand_name?> </strong>
 <br>
 <br>
<table>
<?if(is_array($drinks)) { ?>
<?$num=0;?>
  <form method=post action="<?=$_SERVER[PHP_SELF]?>">
         <tr><td><strong>DRINKS:</strong> </td></tr><?
    foreach ($drinks as $d) { 
      if($d[category] == "DRINK") { 
      $num++;
      $namevar = "drink_".$num;?>
        <TR><TD>
        <input type="text" name="<?=$namevar?>" value="0" size="2"> 
        <?=$d[name]?></td><td>
        <?=$d[cost]?>  </td></tr>
    <?}?>
  <?}?>
  <tr><td>
  <?
  $p->displayVar("num");
  $p->displayVar("choose_drink");
  $p->displayVar("view");
  $p->displayVar("orderid");
?>
</form>
<? }?>
</tr></td>
</table>
<a href="<?=$path->getWebPath("page_concessions");?>"> Cancel </a>
 <?
   $p->close();
?>
