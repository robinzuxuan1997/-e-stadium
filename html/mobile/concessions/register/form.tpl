<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<br>
<h1>Create an Account</h1>

<?$p->errText()?>
<form action="<?=$p->pageName()?>" method="POST">
  <table border=0><tr><td <?$p->errClass("username")?>>
    Username:</td><td>
    <?$p->displayVar("username")?></td></tr><tr><td <?$p->errClass("password1")?>>

    Password:</td><td>
    <?$p->displayVar("password1")?></td></tr><tr><td <?$p->errClass("password2")?>>
    Retype Password:</td><td>
    <?$p->displayVar("password2")?></td></tr><tr><td <?$p->errClass("firstname")?>>
    Firstname: </td><td>
    <?$p->displayVar("firstname")?></td></tr><tr><td <?$p->errClass("lastname")?>>
    Last Name: </td><td>
    <?$p->displayVar("lastname")?> </td></tr><tr><td <?$p->errClass("email")?>>
    Email: </td><td>
    <?$p->displayVar("email")?> </td></tr>
  </table><br>
  <?$p->displayVar("register")?>
  <?$p->displayVar("view")?>
</form>
<?
$p->close();
?>
