<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<br>
<h1>Confirm Delete</h1>
<hr>
Are you sure you want to delete staff <b><?=$name?></b> from season <b><?$p->displayVar("seasonid", "success")?></b> and
team <b><?$p->displayVar("teamid", "success")?></b>?<br>
<hr>
<form action="<?=$p->pageName()?>" method="POST">
  <?$p->displayVar("yes")?>
  <?$p->displayVar("cancel")?>
  <?$p->displayVar("view")?>
  <input type="hidden" name="seasonid" value="<?=$seasonid?>">
  <input type="hidden" name="teamid" value="<?=$teamid?>">
  <input type="hidden" name="staff_userid" value="<?=$staff_userid?>">
</form>
<br>
<?
$p->close();
?>
