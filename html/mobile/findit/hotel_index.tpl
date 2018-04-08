<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<center><font class="mobile_h1"><u>Find Hotels</u><br></font></center>
<form action="<?=$p->pageName?>" method="POST">

<center>
  <font class="mobile_h1">Search by Name:<br></font>
  <?$p->displayVar("hotelid")?><br>
  <?$p->displayVar("submit_hotelname")?><br>
</center>
<br>
<center>
  <font class="mobile_h1">Search by City:<br></font>
  <?$p->displayVar("hotelcityid")?><br>
  <?$p->displayVar("submit_hotelcity")?><br>
</center>
<br>
<center>
  <font class="mobile_h1">Search by Distance:<br></font>
  <?$p->displayVar("hoteldistanceid")?><br>
  <?$p->displayVar("submit_hoteldist")?><br>
</center>
<?$p->displayVar("view")?>
</form>
<?
$p->close();
?>
