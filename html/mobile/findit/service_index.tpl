<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<center><font class="mobile_h1"><u>Ross-Ade Services</u><br></font></center>
<form action="<?=$p->pageName?>" method="POST">

<center>
  <font class="mobile_h1">Please select a service:<br></font>
  <?$p->displayVar("serviceid")?><br>
  <?$p->displayVar("submit_service")?><br>
</center>
<br>
<?if (strlen($service_message)) {?>
<center>
  <b><?=$service_message?></b><br>
  <img src="<?=$service_image?>"><br>
</center>
<?}?>
<?$p->displayVar("view")?>
</form>
<?
$p->close();
?>
