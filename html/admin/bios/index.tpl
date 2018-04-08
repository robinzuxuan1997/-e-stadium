<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<h1>Staff/Player Updates</h1>
<hr>
<?if (strlen($msg) > 0) echo "$msg" . "<br>";?>
<form action="<?=$p->pageName()?>" method="POST">
  <table border=0><tr><td>
    <table border=0><tr><td>
      Season:</td><td>
      <?$p->displayVar("seasonid");?></td></tr><tr><td>
    
      Team:</td><td>
      <?$p->displayVar("teamid");?></td></tr>
    </table></td><td>

    <?$p->displayVar("edit_staff")?><br>
    <?$p->displayVar("edit_players")?><br>
    <?$p->displayVar("season_copy")?><br></td></tr>
  </table>
  <hr>
  <?$p->displayVar("view")?>
</form>
<?
$p->close();
?>
