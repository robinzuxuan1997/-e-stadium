<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<center><font class="mobile_h1"><u>Find Restaurants</u><br></font></center>
<form action="<?=$p->pageName?>" method="POST">

<center>
  <font class="mobile_h1">Search by Name:<br></font>
  <?$p->displayVar("restaurantid")?><br>
  <?$p->displayVar("submit_restaurantname")?><br>
</center>
<br>
<center>
  <font class="mobile_h1">Search by Food Type:<br></font>
  <?$p->displayVar("restaurant_classificationid")?><br>
  <?$p->displayVar("submit_restaurantclassification")?><br>
</center>
<br>
<center>
  <font class="mobile_h1">Search by City:<br></font>
  <?$p->displayVar("restaurant_cityid")?><br>
  <?$p->displayVar("submit_restaurantcity")?><br>
</center>
<br>
<center>
  <font class="mobile_h1">Search by Distance:<br></font>
  <?$p->displayVar("restaurant_distanceid")?><br>
  <?$p->displayVar("submit_restaurantdist")?><br>
</center>
<?$p->displayVar("view")?>
</form>
<?
$p->close();
?>
