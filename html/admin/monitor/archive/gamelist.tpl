<?
$p->startMonitorTemplate();
?>

<center><font class="mobile_h1">Game Archive: <?=$seasonid?><br></font></center>
<?if (!is_array($games) || count ($games) < 0) {?>
  <font class="normal">There are currently no game archives for this season.</font>
<?} else {?>
  <font class="normal">
    <?foreach($games as $g) {?>
       <?=$g[home]?> vs. <?=$g[away]?>: 
       <a href="<?=$p->pageName()?>?view=<?=$view?>&gameid=<?=$g[id]?>">Stats</a>&nbsp;
       <a href="<?=$path->getPath("page_game_videos")?>?gameid=<?=$g[id]?>">Video</a>
       <br>
    <?}?>
  </font>
<?}?>

<?
$p->close();
?>
