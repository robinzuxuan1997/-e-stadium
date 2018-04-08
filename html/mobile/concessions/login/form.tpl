<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<br>
<h1>Login to eStadium</h1>

<?if (strlen($msg) > 0) echo $msg . "<br>";?>

<form action="<?=$p->pageName()?>" method="POST">
  <table border=0><tr><td>
    Username:</td><td>
    <?$p->displayVar("username")?></td></tr><tr><td>

    Pasword:</td><td>
    <?$p->displayVar("password")?></td></tr>
  </table><br>
  <?$p->displayVar("login")?>
  <?$p->displayVar("view")?>
</form>
<a href="<?=$path->getWebPath("page_register")?>"> Register for eStadium </a>
<?
$p->close();
?>
