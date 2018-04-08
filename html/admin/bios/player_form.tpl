<?
$p->startTemplate();
$p->setDisplayMode("form");
?>
<h1>Edit/Add Player</h1>
<?if (strlen($msg) > 0) echo $msg . "<br>";?>
<?$p->errText();?>
<hr>
Season: <?$p->displayVar("seasonid", "success")?><br>
Team: <?$p->displayVar("teamid", "success")?><br>
<hr>
<form enctype="multipart/form-data" action="<?=$p->pageName()?>" method="POST">
  <table border=0><tr><td>
    First name:</td><td <?$p->errClass("player_fname")?>>
    <?$p->displayVar("player_fname")?></td></tr><tr><td>

    Last name:</td><td <?$p->errClass("player_lname")?>>
    <?$p->displayVar("player_lname")?></td></tr><tr><td>

    Number:</td><td <?$p->errClass("player_number")?>>
    <?$p->displayVar("player_number")?></td></tr><tr><td>

    Class:</td><td <?$p->errClass("player_classrankid")?>>
    <?$p->displayVar("player_classrankid")?></td></tr><tr><td>

    Position:</td><td <?$p->errClass("player_positionid")?>>
    <?$p->displayVar("player_positionid")?></td></tr><tr><td>

    Side:</td><td <?$p->errClass("player_offdefst")?>>
    <?$p->displayVar("player_offdefst")?></td></tr><tr><td>

    Height:</td><td <?$p->errClass("player_height")?>>
    <?$p->displayVar("player_height")?></td></tr><tr><td>

    Weight:</td><td <?$p->errClass("player_weight")?>>
    <?$p->displayVar("player_weight")?></td></tr><tr><td>

    Hometown:</td><td <?$p->errClass("player_homelastschool")?>>
    <?$p->displayVar("player_homelastschool")?></td></tr><tr><td>

    Bio:</td><td></td></tr><tr><td colspan=2 align=center <?$p->errClass("player_bio")?>>
    <?$p->displayVar("player_bio")?></td></tr><tr><td>

    Picture:</td><td <?$p->errClass("Player_image")?>>
    <?if (strlen($picturepath) > 0) {?><img src="<?=$picturepath?>"><br> <?}?>
    <?$p->displayVar("player_image")?></td></tr>
  </table><br>

  <?$p->displayVar("save")?>

  <?$p->displayVar("view")?>
  <input type="hidden" name="player_userid" value="<?=$player_userid?>">
  <input type="hidden" name="teamid" value="<?=$teamid?>">
  <input type="hidden" name="seasonid" value="<?=$seasonid?>">
</form>

<?
$p->close();
?>
