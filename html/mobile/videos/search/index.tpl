<?
$p->startTemplate();
$p->setDisplayMode("form");
?>

<center><font class="mobile_h1"><u>Video Search:</u><br></font></center>
<center><font class="mobile_h1"><?=$homeacr?> vs. <?=$awayacr?>:</font>
<form action="<?=$p->pageName()?>" method="POST">
<table border=0><tr><th>
  Search by Player</th></tr><tr><td>
  <?$p->displayVar("playerid")?>&nbsp;&nbsp;<?$p->displayVar("search_by_player")?></td></tr><tr><th>
  Search by Play Type</th></tr><tr><td>
  <?$p->displayVar("playtype")?>&nbsp;&nbsp;<?$p->displayVar("search_by_playtype")?></td></tr>
</table>
<?$p->displayVar("gameid")?>
<?$p->displayVar("view")?>

</form>

<?
$p->close();
?>
