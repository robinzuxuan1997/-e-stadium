<?
$p->startTemplate();
?>
<center><img src="<?=$path->getPath("image_food_locator")?>"></center><br>
<hr>
<b><?=$food_stand_text?> serves the following items:</b><br>
<?foreach($food_items as $food) {?>
  <?=$food[food]?><br>
<?}?>
<hr>
<b><?=$food_stand_text?> can be found at the following locations:</b><br>
<?foreach($locations as $loc) {?>
  <?=$loc[section]?><br>
<?}?>
<hr>
<center><img src="<?=$path->getPath("image_stadium_sections")?>"></center>
<?
$p->close();
?>
