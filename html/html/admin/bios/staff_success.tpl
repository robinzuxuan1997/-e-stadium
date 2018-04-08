<?
$p->startTemplate();
$p->setDisplayMode("success");
?>
<h1>Success</h1>
<?if (strlen($msg) > 0) echo $msg . "<br>";?>
<?$p->errText();?>
<hr>
Season: <?$p->displayVar("seasonid", "success")?><br>
Team: <?$p->displayVar("teamid", "success")?><br>
<hr>
<a href="<?=$p->pageName()?>?view=<?=$view?>&seasonid=<?=$seasonid?>&teamid=<?=$teamid?>&staff_userid=<?=$staff_userid?>">
  Edit <?$p->displayVar("staff_fname")?> <?$p->displayVar("staff_lname")?>'s Information
</a><br>
<a href="<?=$p->pageName()?>?view=<?=$view?>&seasonid=<?=$seasonid?>&teamid=<?=$teamid?>&stafflist=1">
  Return to staff listing
</a><br>
<a href="<?=$p->pageName()?>?seasonid=<?=$seasonid?>&teamid=<?=$teamid?>">
  Return to main
</a><br>
<table border=0><tr><td>
  First name:</td><td <?$p->errClass("staff_fname")?>>
  <?$p->displayVar("staff_fname")?></td></tr><tr><td>

  Last name:</td><td <?$p->errClass("staff_lname")?>>
  <?$p->displayVar("staff_lname")?></td></tr><tr><td>

  Position:</td><td <?$p->errClass("staff_position")?>>
  <?$p->displayVar("staff_position")?></td></tr><tr><td>

  Bio:</td><td></td></tr><tr><td colspan=2 align=left <?$p->errClass?>>
  <?$staff_bio = preg_replace("/\n/", "<br>", $staff_bio);?>
  <?$p->displayVar("staff_bio")?></td></tr><tr><td>

  Picture:</td><td>
  <?if (strlen($picturepath) > 0) {?><img src="<?=$picturepath?>"><br> <?}?>
  <?$p->displayVar("staff_image")?></td></tr>
</table><br>

<?
$p->close();
?>
