<?
$p->startTemplate();
?>
<hr>
<?if (strlen($msg) > 0) {?>
  <font color="red"><b><?=$msg?></b></font><br>
<?}?>
<table><tr><th>Click the camera <img src="<?=$path->getWebPath("image_camera_icon")?>"> icons below to find a video that 
               works on your device, then click the link above that video to save the setting.</th></tr></table>
<a href="#more_info">Scroll down for a more detailed explanation.</a><br>

<?foreach ($choices as $c) {?>
  <hr>
  <table>
    <tr>
      <td>
      <a href="<?=$c[link]?>">
      <img border=0 src="<?=$path->getWebPath("image_camera_icon")?>"></a>
      </td>
      <td>
      <?=$c[text]?><br>
  <a href="<?=$p->pageName()?>?setvideotype=1&medium=<?=$c[medium]?>&encoding=<?=$c[encoding]?>">Set for all videos</a><br>
      </td>
    </tr>
  </table>
<?}?>

<a id="more_info"></a>
<table width="100%"><tr><th id="contrast" align="center">Video Type Explanation</th></tr></table><br>
Different mobile devices have different means of playing video.  We offer five types
of delivery methods in an effort to support the largest set of devices possible.<br><br>

Due to the large number of different mobile devices out there, We do not always 
correctly detect which type of device is requesting video.  To alleviate this 
problem, we present users with this page containing links to all five delivery
methods.<br><br>

Simply click each of the five camera icons above <img src="<?=$path->getWebPath("image_camera_icon")?>">
and decide which one plays video
best on your device.  Once you have decided which camera is best, click the
"This one works for me" link beside that camera.  This will save the new video
setting specifically for you until you close your browser.  All video links
throughout the site will now appear with the delivery method you have chosen.<br><br>

<?
$p->close();
?>
