<?
$p->startTemplate();
?>

<center>
  <font class="mobile_h1"><u>Vote for MVP</u></font><br>
</center>
Your vote has been submitted.<br>
<?=$fname?> <?=$lname?> appreciates your vote!<br>
<br>
<?if ($image) {?>
<center><img src="<?=$path->getPath("image_player_basedir") . "/$image"?>"><br></center>
<?}?>
<center>
  <a class="small" href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$playerid?>"><?=$fname?> <?=$lname?>, <?=$number?></a><br><br>
</center>
<a class="small" href="<?=$path->getPath("page_mvp")?>?results=1">View Current Vote Totals</a><br>

<?
$p->close();
?>
