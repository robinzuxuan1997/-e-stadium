<?
$p->startTemplate();
?>

<center><font class="mobile_h1"><u>Video Search Results:</u><br></font></center>
<center><font class="mobile_h1"><?=$homeacr?> vs. <?=$awayacr?>:</font>
<?if (!is_array($videos) || count($videos) < 1) {?>
  <font class="normal"><br>No videos match your search criteria.</font></center>
  <br><a href="<?=$p->pageName()?>">Search Again</a><br>
<?} else {?>
  <font class="mobile_h1"><br><?=$search_type_message?><br>
  <a href="<?=$p->pageName()?>">Search Again</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$path->getWebPath("page_setvideotype")?>">Change Video Type</a><br></font>
  <table border=0 width="100%">
    <tr>
      <th>&nbsp;Angle&nbsp;</th>
      <th>Description</th>
    </tr>
    <?foreach($videos as $angles) {?>
    <tr>
      <td>
      <?foreach($angles as $v) {?>
          <a class="video" href="<?=Check::constructVideoLink($v[path], $v[filename])?>"><img border=0 src="<?=$path->getPath("image_camera_icon")?>">&nbsp;<?=$v[anglenumber]?></a><br>
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
        <td><b><?=$downspot?></b><?=$desc?></td>
      </tr>
      <tr><td colspan=2><hr></td></tr>
    <?}?>
    </table>
<?}?>

<?
$p->close();
?>
