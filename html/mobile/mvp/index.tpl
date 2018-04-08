<?
$p->startTemplate();
$p->setDisplayMode("form");
?>

<center>
  <font class="mobile_h1"><u>Vote for MVP</u></font><br>
</center>

<?$p->errText()?>

<form action="<?=$p->pageName()?>" method="POST">
Your name:<br>
<?$p->displayVar("voter_name")?><br>
Your email:<br>
<?$p->displayVar("voter_email")?><br>
Most Valuable Player:<br>
<?$p->displayVar("playerid")?><br>
Sort list by: <?$p->displayVar("submit_sortname")?><?$p->displayVar("submit_sortnum")?><br>
<br>
<?$p->displayVar("submit_vote")?><br>

<?$p->displayVar("view")?>
</form>

<?
$p->close();
?>
