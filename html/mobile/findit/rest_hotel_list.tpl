<?
$p->startTemplate();
$p->setDisplayMode("success");
?>
<center><font class="mobile_h1"><u><?=$title_text?></u><br></font></center>
Search Results<br>
You searched for: <?=$search_text?><br>
<br>
<ul>
<?foreach($establishment_list as $e) {?>
  <li><a href="<?=$p->pageName()?>?view=<?$p->displayVar("view")?>&<?=$idvarname?>=<?=$e[id]?>"><?=$e[name]?></a></li>
<?}?>
</ul>

<?
$p->close();
?>
