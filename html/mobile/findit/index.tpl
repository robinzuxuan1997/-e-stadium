<?
$p->startTemplate();
$p->setDisplayMode("success");
?>
<center>
  <font class="mobile_h1"><u>Find It!</u><br></font>
</center>
<ul>
<?foreach($findtype_choices as $f) {?>
  <li><a href="<?=$p->pageName()?>?view=<?$p->displayVar("view")?>&findtype=<?=$f[value]?>"><?=$f[text]?></a></li>
<?}?>
</ul>
<?
$p->close();
?>
