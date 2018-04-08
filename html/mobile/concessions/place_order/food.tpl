<?
  $p->startTemplate();
  $p->setDisplayMode("form");
?>

<h1> Place a New Order </h1>
 <strong> Location: <?=$stand_name?> </strong>
 <br>
 <br>
<table>
<?if(is_array($foods)) { ?>
    <form method=post action="<?=$_SERVER[PHP_SELF]?>">
         <tr><td><strong> FOOD: </strong></td></tr><?
$num=0;
    foreach ($foods as $f) { 
      if($f[category] == "FOOD") { 
        $num++;
        $namevar = "food_".$num;?>
        <tr><td>
        <input type="text" name="<?=$namevar?>" value="0" size="2"> 
        <?=$f[name]?></td><td>
        <?=$f[cost]?>  </td></tr>
   <? } 
    }?>
  <tr><td>
  <?
  $p->displayVar("num");
  $p->displayVar("choose_food");
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
