<?
$p->startTemplate();
?>
<center><img src="<?=$path->getPath("image_food_locator")?>"></center><br>
<hr>
<b><?=$food_item_text?> is available at:</b><br>
<?foreach($stands as $stand) {?>
  <?=$stand[name]?> (<?=$stand[section]?>)<br>
<?}?>
<hr>
<center><img src="<?=$path->getPath("image_stadium_sections")?>"></center>
<?
$p->close();
?>
