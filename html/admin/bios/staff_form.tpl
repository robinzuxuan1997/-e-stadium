<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<h1>Edit/Add Coaches and Staff</h1>
<?if (strlen($msg) > 0) echo $msg . "<br>";?>
<?$p->errText();?>
<hr>
Season: <?$p->displayVar("seasonid", "success")?><br>
Team: <?$p->displayVar("teamid", "success")?><br>
<hr>
<form enctype="multipart/form-data" action="<?=$p->pageName()?>" method="POST">
  <table border=0><tr><td>
    First name:</td><td <?$p->errClass("staff_fname")?>>
    <?$p->displayVar("staff_fname")?></td></tr><tr><td>

    Last name:</td><td <?$p->errClass("staff_lname")?>>
    <?$p->displayVar("staff_lname")?></td></tr><tr><td>

    Position:</td><td <?$p->errClass("staff_position")?>>
    <?$p->displayVar("staff_position")?></td></tr><tr><td>

    Bio:</td><td></td></tr><tr><td colspan=2 align=center <?$p->errClass("staff_bio")?>>
    <?$p->displayVar("staff_bio")?></td></tr><tr><td>

    Picture:</td><td <?$p->errClass("staff_image")?>>
    <?if (strlen($picturepath) > 0) {?><img src="<?=$picturepath?>"><br> <?}?>
    <?$p->displayVar("staff_image")?></td></tr>
  </table><br>

  <?$p->displayVar("save")?>

  <?$p->displayVar("view")?>
  <input type="hidden" name="staff_userid" value="<?=$staff_userid?>">
  <input type="hidden" name="teamid" value="<?=$teamid?>">
  <input type="hidden" name="seasonid" value="<?=$seasonid?>">
</form>

<?
$p->close();
?>
