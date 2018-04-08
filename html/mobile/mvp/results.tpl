<?
$p->startTemplate();
?>
<center>
  <font class="mobile_h1"><u>MVP Voting Results</u></font><br>
</center>

Current winning player: <a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$votes[0][playerid]?>">
<?=$votes[0][name]?>, #<?=$votes[0][number]?></a><br>
<hr>
Counting <?=$total_votes?> votes.
<hr>
<table border=0><tr><th>
  Player</th><th>
  Votes</th>
</tr>
<?foreach($votes as $v) {?>
  <tr><td>
    <a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$v[playerid]?>"><?=$v[name]?>, #<?=$v[number]?></a></td><td>
    <?=$v[votecount]?></td>
  </tr>
<?}?>
</table>

<?
$p->close();
?>
