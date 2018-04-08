<?
$p->startTemplate();
$p->setDisplayMode("success");
?>

<h1>Success</h1>
<table border=0><tr><td>
  Username:</td><td>
  <?$p->displayVar("username")?></td></tr><tr><td>

  Email:</td><td>
  <?$p->displayVar("email")?></td></tr><tr><td>

  First Name: </td><td>
  <?$p->displayVar("firstname")?> </td></tr><tr><td>

  Last Name: </td><td>
  <?$p->displayVar("lastname")?> </td></tr>


</table><br>

<a href="<?=$path->getWebPath("page_login")?>?>">Return to Login</a><br>
<?
$p->close();
?>
