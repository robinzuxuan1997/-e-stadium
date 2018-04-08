<?
$p->startTemplate();
?>
<center><font class="mobile_h1"><u>Video Highlights</u><br></font></center>
<?if (strlen($errmsg) > 0) {?>
  <center><font color="#FF0000"><?=$errmsg?><br></font></center>
<?}?>
<form method="post" action="<?=$p->pageName()?>">
<center>Please enter the access code to view video highlights. The access code will be announced and displayed on the video board.</center><br>
<center>Code:<?$p->displayVar("acode", "form");?>&nbsp;&nbsp;<?$p->displayVar("submit", "form");?></center>
<?$p->displayVar("view", "form");?>
</form>

<?
$p->close();
?>
