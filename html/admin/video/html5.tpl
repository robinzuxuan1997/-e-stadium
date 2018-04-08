<?
$p->startTemplate();
$p->setDisplayMode("form");
?><br>

<?if (strlen($msg) > 0) { 
    ?><h2><font color="#FF0000"><?=$msg?></font></h2><? 
  }
  $p->errText();
?><br/>

<table width="100%" border=0 bgcolor="#DEB887"><tr><td valign=middle align=center>
  <font size=5><br/><b>Associate <font color="#FF0000"><u><?=strtoupper($new_or_existing)?></u></font> Videos with Plays</b><br><br></font>
</td></tr></table>
<hr>

<center>
  <a href="<?=$p->pageName()?>?view=<?=$view?>&new_or_existing=<?=$opposite_new_or_existing?>">
    Switch to <?=$opposite_new_or_existing?> Video Associations
  </a>
</center><br>

<form action="<?=$p->pageName()?>" method="POST">
  <?$p->displayVar("refresh");?>
  <?$p->displayVar("view");?>
  <?$p->displayVar("quarter");?>
  <?$p->displayVar("new_or_existing");?>
&nbsp;&nbsp;&nbsp;&nbsp;<b>Quarters:</b> |&nbsp;&nbsp;
<?foreach($quarters as $q) {
  if ($q != $quarter) {
    ?><a href="<?=$p->pageName()?>?view=<?=$view?>&new_or_existing=<?=$new_or_existing?>&quarter=<?=$q?>"><?
  }
  ?>Q<?=$q?><?
  if ($q != $quarter) {
    ?></a><?
  }
  ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?
}?>
  <?$p->displayVar("refresh");?>
</form>

<table border=0 cellpadding=5 width="1000px"><tr><th>
  Video File:</th><th>
  Angles:</th><th>
  Save:</th><th>
  Play:</th></tr>

  <?if (!is_array($videos) || count($videos) < 1) {?>
    <tr><td colspan="4"><br/>There are no <?=$new_or_existing?> videos in the database at this time.<br/></td></tr>
  <?} else {
    foreach($videos as $angles) {?>
      <form action="<?=$p->pageName()?>" method="POST">
      <tr valign="middle">
        <td valign="middle" align="center">
          <b><font size=2>Q<?=$quarter?>/<?=preg_replace("/_[0-9]+.*/", "", $angles[0][filename])?></font></b><br/>
          <?$approved = $angles[0][approved];?>
        </td>
        <td valign="middle" align="center"><?
          for ($a=0; $a<count($angles); $a++) {?>
            <input type="hidden" name="videoids[<?=$a?>]" value="<?=$angles[$a][videoid]?>"/>
            <table border="0">
              <tr>
                <td valign="center" align="center">
                  <font size="2"><b><?=$a?></b></font>
                </td>
                <td valign="center" align="center">
                  <?$trans_dirs = $SETTINGS[trans_dirs];
                  rsort($trans_dirs);?>
                  <video controls="true" preload="none"
                  	src="<?=Check::constructVideoLink($angles[$a][webpath], $angles[$a][filename], "download", "MOBILE_MP4")?>"
                  	poster="<?=Check::constructVideoLink($angles[$a][webpath], $angles[$a][filename], "download", "MOBILE_MP4","jpg")?>"
                  	>
                  
                  </video>
                  <table border="0">
                    <?foreach($trans_dirs as $trans) {
                      if ($counter^=1) { ?><tr><? } ?>
                      <td>
                        <a href="<?=Check::constructVideoLink($angles[$a][webpath], $angles[$a][filename], "download", $trans)?>" target="_blank">
                          <?=strtoupper(GlobalSettings::noTrailingSlash($trans))?>
                        </a>
                      </td><?
                      if (!$counter) { ?></tr><? }
                    }
                    if ($counter) {
                      ?><td></td></tr><?
                    }?>
                  </table>
                </td>
              </tr>
            </table>
            <br/>
          <?}?>
        </td>
        <td align="center"><?
          $p->displayVar("approved");
          $p->displayVar("save");
          $p->displayVar("view");
          $p->displayVar("quarter");
          $p->displayVar("new_or_existing");?>
        </td>
        <td><? 
          if (strlen($angles[0][old_text]) > 0) { // this particular video set has old play text
            ?>Old Play Text: <?=$angles[0][old_text]?><br/><?
           }
           $playid = $angles[0][playid];
           $p->displayVar("playid"); ?>
        </td>
      </tr>
      </form>
      <tr>
        <td colspan="4">
          <hr>
        </td>
      </tr><?
    }
  }?>
</table>
</center>
<form action="<?=$p->pageName()?>" method="POST">
  <?$p->displayVar("refresh");?>
  <?$p->displayVar("view");?>
  <?$p->displayVar("new_or_existing");?>
</form>

<?
$p->close();
?>
