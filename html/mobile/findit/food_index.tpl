<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<center><img src="<?=$path->getPath("image_food_locator")?>"></center><br>
<form action="<?=$p->pageName?>" method="POST">

<center>
  <font class="mobile_h1">Search by location:<br></font>
  <?$p->displayVar("foodlocationid")?><br>
  <?$p->displayVar("submit_foodlocation")?><br>
</center>
<br>
<center>
  <font class="mobile_h1">Search by food item:<br></font>
  <?$p->displayVar("fooditemid")?><br>
  <?$p->displayVar("submit_fooditem")?><br>
</center>
<br>
<center>
  <font class="mobile_h1">Search by food stand:<br></font>
  <?$p->displayVar("foodstandid")?><br>
  <?$p->displayVar("submit_foodstand")?><br>
</center>
<?$p->displayVar("view")?>
</form>
<?
$p->close();
?>
