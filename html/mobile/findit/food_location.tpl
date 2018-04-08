<?
$p->startTemplate();
?>
<center><img src="<?=$path->getPath("image_food_locator")?>"></center><br>
<hr>
<b>You are near the following stands:</b><br>
<?foreach($near_stands as $stand) {?>
  <?=$stand[stand_name]?> (<?=$stand[stand_section]?>)<br>
<?}?>
<hr>
<center><img src="<?=$path->getPath("image_stadium_sections")?>"></center>
<?
$p->close();
?>
