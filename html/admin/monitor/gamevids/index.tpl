<?
$p->startMonitorTemplate();
?>
<center><font class="mobile_h1"><u>Video Highlights: <?=$season?></u><br></font></center>
<center><font class="mobile_h1"><?=$homeacr?> vs. <?=$awayacr?>:</font>
<?if (!is_array($quarters) || count($quarters) < 1) {?>
  <font class="normal"><br>No highlights are available at this time.</font></center>
<?} else {
  if (count($quarters) > 4) {?><font class="mobile_h1"><br></font><?}?>
  <?for($i=0; $i<count($quarters); $i++) {?>
    <a href="<?=$p->pageName()?>?gameid=<?=$gameid?>&quarter=<?=$quarters[$i]?>">Q<?=$quarters[$i]?></a>
    <?if ($i < count($quarters)-1) {?> | <?}?>
  <?}?>
  </center>
  <center><a href="<?=$path->getWebPath("page_video_search")?>">Search Videos</a>&nbsp;&nbsp;
          <a href="<?=$path->getWebPath("page_setvideotype")?>">Video Type</a></center>
  <font class="mobile_h1"><br>Quarter <?=$quarter?><br/></font>
  <table border=0 width="100%">
    <tr>
      <th>&nbsp;Angle&nbsp;</th>
      <th>Description</th>
    </tr>
    <?foreach($videos as $angles) {?>
    <tr>
      <td>
      <?foreach($angles as $v) {?>
          <a <?if ($opennewpage) { ?>target="videoviewer" <?}?> class="video" href="<?=Check::constructVideoLink($v[path], $v[filename])?>"><img border=0 src="<?=$path->getPath("image_camera_icon")?>">&nbsp;<?=$v[anglenumber]?></a><br>
      <?}?>
      </td>
      <?if (preg_match("/:/", $v[text])) {
        // Use the last "$v" item as the authoritative text description.
        $text = split(":", $v[text]);
        $downspot = trim($text[0]) . ": ";
        $desc = "";
        for ($i=1; $i<count($text); $i++) {
          $desc .= trim($text[$i]) . " ";
        }
        $desc = trim($desc);
      } else { // Cases like "Recent Play"
        $downspot = "";
        $desc = $v[text];
      }?>
        <td><b><?=$downspot?></b><?=stripslashes($desc)?></td>
      </tr>
      <tr><td colspan=2><hr></td></tr>
    <?}?>
    </table>
<?}

$p->Close();

?>
