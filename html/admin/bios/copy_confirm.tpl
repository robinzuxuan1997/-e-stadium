<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<h1>Confirm Season Copy</h1>
Please confirm that you want to perform this copy.<br>
<form method="POST" action="<?=$p->pageName()?>">
  Team: <?$p->displayVar("team", "success")?><br>
  <table border=0><tr><td>

    Copy From Season:</td><td>
    <?$p->displayVar("seasonid", "success")?></td></tr><tr><td>

    To Season:</td><td>
    <?$p->displayVar("copy_to_season", "success")?></td></tr>

  </table>
  <hr>
  <?if (count($duplicates) < 1) {?>
    No conflicts detected: no player or staff information will be overwritten.<br>
  <?} else {?>
    <h1>Warning: the following existing players and staff in<br><br>
    Season <?$p->displayVar("copy_to_season", "success")?>  will be overwritten with<br><br>
    information from Season <?$p->displayVar("seasonid", "success")?>.  Are you sure?</h1><hr>
    <h2>Players</h2>
    <?foreach($duplicates as $c) {
      if ($c[type] == "player") {
        $p->displayVar($c[varname]);
        ?><br><?
      }
    }?>
    <hr>
    <h2>Coaches/Staff</h2>
    <?foreach($duplicates as $c) {
      if ($c[type] == "staff") {
        $p->displayVar($c[varname]);
        ?><br><?
      }
    }
  }?>
  <?foreach($non_duplicates as $c) {
    $varname = $c[varname];?>
    <input type=hidden name="<?=$varname?>" value="<?=$$varname?>">
  <?}?>

  <?$p->displayVar("confirm")?>
  <?$p->displayVar("view")?>
  <input type=hidden name="seasonid" value="<?=$seasonid?>">
  <input type=hidden name="teamid" value="<?=$teamid?>">
  <input type=hidden name="copy_to_season" value="<?=$copy_to_season?>">

</form>

<?
$p->close();
?>
