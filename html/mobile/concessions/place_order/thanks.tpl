<?
$p->startTemplate();
?>

<h1> Thanks for your Order! </h1>
<? if($time) {?>
Your order will be done in approximately <?=$minutes?> minutes. 
<? }else{?>
Your order will be ready shortly. 
<?}?>

<BR>
<BR>
<a href="<?=$path->getWebPath("page_concessions")?>"> Back to Concessions </a><BR>
<a href="<?=$path->getWebPath("page_index")?> "> Back to Main </a><BR>

<?
  $p->displayVar("view");
  $p->close();
?>
