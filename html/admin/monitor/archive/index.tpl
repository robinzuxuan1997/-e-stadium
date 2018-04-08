<?
$p->startMonitorTemplate();
?>
<center><font class="mobile_h1">Game Archive<br></font></center>
<? if (!is_array($seasons) || count($seasons) < 1) {?>
  <font class="normal">
    There are currently no seasons to view.
  </font>
<?} else {?>
  <font class="normal">
    Please select a season:<br>
  <?foreach($seasons as $s) {?>
    <a class="normal" href="<?=$p->pageName()?>?view=<?=$view?>&seasonid=<?=$s?>"><?=$s?></a><br>
  <?}?>
  </font>
<?}?>

<?
$p->close();
?>
