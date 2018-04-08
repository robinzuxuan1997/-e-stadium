<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<form method="POST" action="<?=$p->pageName()?>">
  <table border=0><tr><td align=right>

    Team:</td><td>
    <?$p->displayVar("teamid", "success")?></td></tr><tr><td align=right>

    Copy From Season:</td><td>
    <?$p->displayVar("seasonid", "success")?></td></tr><tr><td align=right>

    To Season:</td><td>
    <?$p->displayVar("copy_to_season")?></td></tr>

  </table>
  <hr>
  <h1>Players</h1>
  <?foreach($copy_varnames as $c) {
    if ($c[type] == "player") {
      $p->displayVar($c[varname]);
      ?><br><?
    }
  }?>
  <hr>
  <h1>Coaches/Staff</h1>
  <?foreach($copy_varnames as $c) {
    if ($c[type] == "staff") {
      $p->displayVar($c[varname]);
      ?><br><?
    }
  }?>

  <?$p->displayVar("copy")?>
  <?$p->displayVar("view")?>
  <input type=hidden name="seasonid" value="<?=$seasonid?>">
  <input type=hidden name="teamid" value="<?=$teamid?>">

  </form>
<?
$p->close();
?>

