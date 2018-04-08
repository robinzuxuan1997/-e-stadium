<?
  $p->startTemplate();
?>

<table> <tr><td>

  <a href="<?=$path->getWebPath("page_concessions_order_status")?>"> Check Order Status </a> </td></tr><tr><td>
  <a href="<?=$path->getWebPath("page_concessions_place_order")?>"> Place Order </a></td></tr><tr><td>
  <? /* 
  <a href="<?=$path->getWebPath("page_concessions_choose_location")?>"> Choose Location </a></td></tr><tr><td> 
  <a href="<?=$path->getWebPath("page_concessions_place_order")?>?usual=1"> "The Usual" </a></td></tr>
  */?>

</table>

<?
  $p->close();
?>
