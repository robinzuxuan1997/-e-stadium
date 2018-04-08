<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<br>
<h1>Edit/Add Coaches and Staff</h1>
<?if (strlen($msg) > 0) echo $msg . "<br>";?>
<hr>
Season: <?$p->displayVar("seasonid", "success")?><br>
Team: <?$p->displayVar("teamid", "success")?><br>
<hr>
<a href="<?=$p->pageName()?>?view=<?=$view?>&add=1&seasonid=<?=$seasonid?>&teamid=<?=$teamid?>">Add New Coach/Staff</a><br>
<form action="<?=$p->pageName()?>" method="POST">
  <?$p->displayVar("staff_userid")?><br>
  <?$p->displayVar("delete")?>
  <?$p->displayVar("view")?>
  <input type="reset" name="reset">
  <input type="hidden" name="teamid" value="<?=$teamid?>">
  <input type="hidden" name="seasonid" value="<?=$seasonid?>">
</form>
<a href="<?=$p->pageName?>">Back to main staff/player updates page.</a><br><br>
<?
$p->close();
?>
