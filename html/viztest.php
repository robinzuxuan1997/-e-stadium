<?
include_once(realpath(dirname(__FILE__) . "/../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_viz_play"));
include_once($path->getFilePath("class_viz_field"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_drive"));

$driveid = $_REQUEST[driveid];
$last15 = $_REQUEST[last15];
$width=$_REQUEST[width];
$height=$_REQUEST[height];
$a[gameid] = $_REQUEST[gameid];

if (!Game::idExists($a[gameid])) {
  $setup = new Setup();
  $setup->loadCurrent();
  $a[gameid] = $setup->getActiveGameID();
}
if (!Drive::idExists($driveid)) {
  $d = new Drive();
  $drive = new Drive($d->findMaxDriveIndexDriveidByGameid($a[gameid]));
} else {
  $drive = new Drive($driveid);
}

if ($width > 0) {
  $wh = "--width=$width --height=$height";
  $a[width] = $width;
  $a[height] = $height;
}

if ($last15) {
  $last_or_drive = "--last15 --gameid=$a[gameid]";
} else {
  $last_or_drive = "--driveid=$driveid";
}

$a[driveid] = $drive->getID();
$driveid = $a[driveid];

$a[gameid] = $drive->getGameID();
$a[game] = new Game($a[gameid]);


$a[game] = new Game($a[gameid]);
$a[width] = 240;
$a[height] = 320;
$a[orient] = "portrait";
$a[num_possible_plays] = 25;

$f = new VizField($a);

$filename = "viztest.png";
ob_start();
echo "cd ".$path->getFileRoot()."../scripts/create_images/drivetracker/; php gameviz_image.php --printplayids $last_or_drive $wh  $filename; cp $filename ../../../site/.\n";
system("cd ".$path->getFileRoot()."../scripts/create_images/drivetracker/; php gameviz_image.php --printplayids $last_or_drive $wh $filename; cp $filename ../../../site/.\n");
$res = ob_get_contents();
ob_end_clean();
$lines = split("\n", $res);

?>
<html><body>
<?
$db_plays = array();
$not_db_plays = array();
foreach($lines as $l) {
  if (trim($l) == "") continue;
  if (preg_match("/(.*)drawing playid: ([0-9]+)/", $l, $matches)) {
    $vp = new VizPlay(new Play($matches[2]), $f);
    array_push($db_plays, $vp);
    if (strlen($matches[1] > 0)) {
      echo htmlspecialchars($l) . "<br/>";
    }
    if ($vp->isFumble()) $fumble_found = true;
  }
  elseif (preg_match("/(.*)NOT drawing: ([0-9]+)/", $l, $matches)) {
    $vp = new VizPlay(new Play($matches[2]), $f);
    array_push($not_db_plays, $vp);
    if (strlen($matches[1] > 0)) {
      echo htmlspecialchars($l) . "<br/>";
    }
    if ($vp->isFumble()) $fumble_found = true;
  }
  else {
    echo htmlspecialchars($l) . "<br/>";
  }
}

?>
<hr/>
<?if ($fumble_found) { ?><font color="#FF0000" size="5">FUMBLE FOUND!!</font><hr/><?}?>
Game: <?=$a[gameid]?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$_SERVER[PHP_SELF]?>?last15=true&gameid=<?=$a[gameid]?>">Last 15</a><br/>
<a href="<?=$_SERVER[PHP_SELF]?>?driveid=<?=($driveid-1)?>">Prev Drive</a>&nbsp;&nbsp;&nbsp;&nbsp;
Drive: <?=$driveid?>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?=$_SERVER[PHP_SELF]?>?driveid=<?=($driveid+1)?>">Next Drive</a><br/>

<table border=0 width="100%">
  <tr><td valign="top"><img src="<?=$filename?>?junk=<?=uniqid(microtime())?>"></td><td>

  <br/>Plays NOT drawn:<br/>
  <table border=1>
    <tr>
      <th>#</th>
      <th>ID</th>
      <th>Info</th>
      <th>Text</th>
    </tr>
    <?$counter = 0;?>
    <?foreach ($not_db_plays as $p) {?>
        <tr>
          <td align=center><?=$counter++?></td>
          <td><?=$p->getID()?></td>
          <td><pre><?unset($p->info[text]); print_r($p->info);?></pre></td>
          <td><?=$p->getText();?></td>
        </tr>
    <?}?>
  </table>

  <br/>Plays drawn:<br/>
  <table border=1>
    <tr>
      <th>#</th>
      <th>ID</th>
      <th>Info</th>
      <th>Text</th>
    </tr>
    <?$counter = 0;?>
    <?foreach ($db_plays as $p) {?>
        <tr>
          <td align=center><?=$counter++?></td>
          <td><?=$p->getID()?></td>
          <td><pre><?unset($p->info[text]); print_r($p->info);?></pre></td>
          <td><?=$p->getText();?></td>
        </tr>
    <?}?>
  </table>

</td></tr></table>

</body></html>
