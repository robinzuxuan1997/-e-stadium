<?
$p->startTemplate();
?>

<center><font size="2"><u><?=$teamname?> Player Stats</u></font><br></center>
<br>

<font size="2">

<table border=0 width="100%" >
  <tr>
    <th align=left>Passing</th>
  </tr>
  <?
  if (!is_array($passers) || count($passers) == 0) {?>
    <tr>
      <td align=center>None</td>
    </tr>
  <?} else {?>
    <tr>
      <td>
        <table border=0 width="100%" >
          <tr>
            <td></td>
            <td align=center><b>CP</b></td>
            <td align=center><b>ATT</b></td>
            <td align=center><b>YDS</b></td>
            <td align=center><b>TD</b></td>
            <td align=center><b>INT</b></td>
          </tr>
          <?foreach($passers as $passer) {?>
          <tr>
            <?if (Check::isInt($passer[id])) {?>
              <td><a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$passer[id]?>"><?=$passer[name]?></a></td>
            <?} else {?>
              <td><?=$passer[name]?></td>
            <?}?>

            <td align=center><?=$passer[cp]?></td>
            <td align=center><?=$passer[att]?></td>
            <td align=center><?=$passer[yds]?></td>
            <td align=center><?=$passer[tds]?></td>
            <td align=center><?=$passer["int"]?></td>
          </tr>
          <?}?>
        </table>
      </td>
    </tr>
  <?}?>

  <tr>
    <th align=left>Rushing</th>
  </tr>
  <?
  if (!is_array($rushers) || count($rushers) == 0) {?>
    <tr>
      <td align=center>None</td>
    </tr>
  <?} else {?>
    <tr>
      <td>
        <table border=0 width="100%">
          <tr>
            <td></td>
            <td align=center><b>ATT</b></td>
            <td align=center><b>YDS</b></td>
            <td align=center><b>TD</b></td>
          </tr>
          <?foreach($rushers as $rusher) {?>
          <tr>
            <?if (Check::isInt($passer[id])) {?>
              <td><a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$rusher[id]?>"><?=$rusher[name]?></a></td>
            <?} else {?>
              <td><?=$rusher[name]?></td>
            <?}?>
            <td align=center><?=$rusher[att]?></td>
            <td align=center><?=$rusher[yds]?></td>
            <td align=center><?=$rusher[tds]?></td>
          </tr>
          <?}?>
        </table>
      </td>
    </tr>
  <?}?>

  <tr>
    <th align=left>Receiving</th>
  </tr>
  <?
  if (!is_array($receivers) || count($receivers) == 0) {?>
    <tr>
      <td align=center>None</td>
    </tr>
  <?} else {?>
    <tr>
      <td>
        <table border=0 width="100%">
          <tr>
            <td></td>
            <td align=center><b>REC</b></td>
            <td align=center><b>YDS</b></td>
            <td align=center><b>TD</b></td>
          </tr>
          <?foreach($receivers as $receiver) {?>
          <tr>
            <?if (Check::isInt($passer[id])) {?>
              <td><a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$receiver[id]?>"><?=$receiver[name]?></a></td>
            <?} else {?>
              <td><?=$receiver[name]?></td>
            <?}?>
            <td align=center><?=$receiver[rec]?></td>
            <td align=center><?=$receiver[yds]?></td>
            <td align=center><?=$receiver[tds]?></td>
          </tr>
          <?}?>
        </table>
      </td>
    </tr>
  <?}?>

  <tr>
    <th align=left>Punting</th>
  </tr>
  <?
  if (!is_array($punters) || count($punters) == 0) {?>
    <tr>
      <td align=center>None</td>
    </tr>
  <?} else {?>
    <tr>
      <td>
        <table border=0 width="100%">
          <tr>
            <td></td>
            <td align=center><b>PUNT</b></td>
            <td align=center><b>YDS</b></td>
            <td align=center><b>LONG</b></td>
          </tr>
          <?foreach($punters as $punter) {?>
          <tr>
            <?if (Check::isInt($passer[id])) {?>
              <td><a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$punter[id]?>"><?=$punter[name]?></a></td>
            <?} else {?>
              <td><?=$punter[name]?></td>
            <?}?>
            <td align=center><?=$punter[punt]?></td>
            <td align=center><?=$punter[yds]?></td>
            <td align=center><?=$punter[long]?></td>
          </tr>
          <?}?>
        </table>
      </td>
    </tr>
  <?}?>

  <tr>
    <th align=left>Kick Returns</th>
  </tr>
  <?
  if (!is_array($kickreturners) || count($kickreturners) == 0) {?>
    <tr>
      <td align=center>None</td>
    </tr>
  <?} else {?>
    <tr>
      <td>
        <table border=0 width="100%">
          <tr>
            <td></td>
            <td align=center><b>RET</b></td>
            <td align=center><b>YDS</b></td>
            <td align=center><b>LONG</b></td>
          </tr>
          <?foreach($kickreturners as $kickreturner) {?>
          <tr>
            <?if (Check::isInt($passer[id])) {?>
              <td><a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$kickreturner[id]?>"><?=$kickreturner[name]?></a></td>
            <?} else {?>
              <td><?=$kickreturner[name]?></td>
            <?}?>
            <td align=center><?=$kickreturner[ret]?></td>
            <td align=center><?=$kickreturner[yds]?></td>
            <td align=center><?=$kickreturner[long]?></td>
          </tr>
          <?}?>
        </table>
      </td>
    </tr>
  <?}?>

  <tr>
    <th align=left>Punt Returns</th>
  </tr>
  <?
  if (!is_array($puntreturners) || count($puntreturners) == 0) {?>
    <tr>
      <td align=center>None</td>
    </tr>
  <?} else {?>
    <tr>
      <td>
        <table border=0 width="100%">
          <tr>
            <td></td>
            <td align=center><b>RET</b></td>
            <td align=center><b>YDS</b></td>
            <td align=center><b>LONG</b></td>
          </tr>
          <?foreach($puntreturners as $puntreturner) {?>
          <tr>
            <?if (Check::isInt($passer[id])) {?>
              <td><a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$puntreturner[id]?>"><?=$puntreturner[name]?></a></td>
            <?} else {?>
              <td><?=$puntreturner[name]?></td>
            <?}?>
            <td align=center><?=$puntreturner[ret]?></td>
            <td align=center><?=$puntreturner[yds]?></td>
            <td align=center><?=$puntreturner[long]?></td>
          </tr>
          <?}?>
        </table>
      </td>
    </tr>
  <?}?>

  <tr>
    <th align=left>Defense</th>
  </tr>
  <?
  if (!is_array($defense) || count($defense) == 0) {?>
    <tr>
      <td align=center>None</td>
    </tr>
  <?} else {?>
    <tr>
      <td>
        <table border=0 width="100%">
          <tr>
            <td></td>
            <td align=center><b>TKLS</b></td>
            <td align=center><b>SACK</b></td>
            <td align=center><b>INT</b></td>
          </tr>
          <?foreach($defense as $d) {?>
          <tr>
            <?if (Check::isInt($passer[id])) {?>
              <td><a href="<?=$path->getPath("page_player_bio")?>?view=index&playerid=<?=$d[id]?>"><?=$d[name]?></a></td>
            <?} else {?>
              <td><?=$d[name]?></td>
            <?}?>
            <td align=center><?=$d[tkls]?></td>
            <td align=center><?=$d[sks]?></td>
            <td align=center><?=$d["int"]?></td>
          </tr>
          <?}?>
        </table>
      </td>
    </tr>
  <?}?>



</table>
</font>
<?
$p->close();
?>
