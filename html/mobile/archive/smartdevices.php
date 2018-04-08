<?
// Set the "false" variables to "0" to make it look better
if (!$hometime_possession)
      $hometime_possession = "0:00";
if (!$awaytime_possession)
      $awaytime_possession = "0:00";
if (!$homedefense[tackles][sackyds])
      $homedefense[tackles][sackyds] = 0;
if (!$awaydefense[tackles][sackyds])
      $awaydefense[tackles][sackyds] = 0;
if (!$homedefense[tackles][tflyds])
      $homedefense[tackles][tflyds] = 0;
if (!$awaydefense[tackles][tflyds])
      $awaydefense[tackles][tflyds] = 0;
if (!$homedefense[fumbles][forced])
      $homedefense[fumbles][forced] = 0;
if (!$awaydefense[fumbles][forced])
      $awaydefense[fumbles][forced] = 0;
if (!$homedefense[fumbles][recovered])
      $homedefense[fumbles][recovered] = 0;
if (!$awaydefense[fumbles][recovered])
      $awaydefense[fumbles][recovered] = 0;
if (!$homedefense[fumbles][yds])
      $homedefense[fumbles][yds] = 0;
if (!$awaydefense[fumbles][yds])
      $awaydefense[fumbles][yds] = 0;
if (!$homedefense[inter][num])
      $homedefense[inter][num] = 0;
if (!$awaydefense[inter][num])
      $awaydefense[inter][num] = 0;
if (!$homedefense[inter][yds])
      $homedefense[inter][yds] = 0;
if (!$awaydefense[inter][yds])
      $awaydefense[inter][yds] = 0;
?>

<center>
      <table width="80%" cellpadding=1 cellspacing=3 >
            <tr>
                  <th width="60%">Scoring:</th>
                  <th width="20%"><?= $awayacronym ?></th>
                  <th width="20%"><?= $homeacronym ?></th>
            </tr>
<?
$count = 0;
foreach ($homescores as $key => $value) {
      $count++
?>
            <tr>
<? if ($count == count($homescores)) { ?>
                  <th align=center><?= $key ?></th>
                  <th align=center><?= $awayscores[$key] ?></th>
                  <th align=center><?= $homescores[$key] ?></th>
<? } else { ?>
                  <td align=center><?= $key ?></td>
                  <td align=center><?= $awayscores[$key] ?></td>
                  <td align=center><?= $homescores[$key] ?></td>
<? } ?>
            </tr>
<? } ?>
            <tr>
                  <th align=center>First Downs</th>
                  <th align=center><?= $awaydowns[first] ?></th>
                  <th align=center><?= $homedowns[first] ?></th>
            </tr>
            <tr>
                  <td align=center>3rd Down Efficiency</td>
                  <td align=center><?= $awaydowns[third][successes] ?>-<?= $awaydowns[third][attempts] ?></td>
                  <td align=center><?= $homedowns[third][successes] ?>-<?= $homedowns[third][attempts] ?></td>
            </tr>
            <tr>
                  <td align=center>4th Down Efficiency</td>
                  <td align=center><?= $awaydowns[fourth][successes] ?>-<?= $awaydowns[fourth][attempts] ?></td>
                  <td align=center><?= $homedowns[fourth][successes] ?>-<?= $homedowns[fourth][attempts] ?></td>
            </tr>
            <tr>
                  <th align=center>Total Yards</th>
                  <th align=center><?= ($awayyards[passing][yards] + $awayyards[rushing][yards]) ?></th>
                  <th align=center><?= ($homeyards[passing][yards] + $homeyards[rushing][yards]) ?></th>
            </tr>
            <tr>
                  <th align=center>Passing Yards</th>
                  <td align=center><b><?= $awayyards[passing][yards] ?></b></td>
                  <td align=center><b><?= $homeyards[passing][yards] ?></b></td>
            </tr>
            <tr>
                  <td align=center>Comp-Att</td>
                  <td align=center><?= $awayyards[passing][completions] ?>-<?= $awayyards[passing][attempts] ?></td>
                  <td align=center><?= $homeyards[passing][completions] ?>-<?= $homeyards[passing][attempts] ?></td>
            </tr>
            <tr>
                  <td align=center>Yards per Pass</td>
                  <td align=center><?
                        if ($awayyards[passing][completions]) {
                              printf("%.1lf", ($awayyards[passing][yards] / $awayyards[passing][completions]));
                        } else {
                              echo "0";
                        }
?></td>
                  <td align=center><?
                        if ($homeyards[passing][completions]) {
                              printf("%.1lf", ($homeyards[passing][yards] / $homeyards[passing][completions]));
                        } else {
                              echo "0";
                        }
?></td>
            </tr>
            <tr>
                  <th align=center>Rushing Yards</th>
                  <td align=center><b><?= $awayyards[rushing][yards] ?></b></td>
                  <td align=center><b><?= $homeyards[rushing][yards] ?></b></td>
            </tr>
            <tr>
                  <td align=center>Yards Per Rush</td>
                  <td align=center><?
                        if ($awayyards[rushing][attempts]) {
                              printf("%.1lf", ($awayyards[rushing][yards] / $awayyards[rushing][attempts]));
                        } else {
                              echo "0";
                        }
?></td>
                  <td align=center><?
                        if ($homeyards[rushing][attempts]) {
                              printf("%.1lf", ($homeyards[rushing][yards] / $homeyards[rushing][attempts]));
                        } else {
                              echo "0";
                        }
?></td>
            </tr>
            <tr>
                  <th align=center>Penalties-Yards</th>
                  <td align=center><b><?= $awayyards[penalty][number] ?>-<?= $awayyards[penalty][yards] ?></b></td>
                  <td align=center><b><?= $homeyards[penalty][number] ?>-<?= $homeyards[penalty][yards] ?></b></td>
            </tr>
            <tr>
                  <th align=center>Turnovers</th>
                  <th align=center><?= ($awayyards[turnovers][fumbles] + $awayyards[turnovers][interceptions]) ?></th>
                  <th align=center><?= ($homeyards[turnovers][fumbles] + $homeyards[turnovers][interceptions]) ?></th>
            </tr>
            <tr>
                  <td align=center>Fumbles</td>
                  <td align=center><?= $awayyards[turnovers][fumbles] ?></td>
                              <td align=center><?= $homeyards[turnovers][fumbles] ?></td>
                        </tr>
                        <tr>
                              <td align=center>Interceptions</td>
                              <td align=center><?= $awayyards[turnovers][interceptions] ?></td>
                              <td align=center><?= $homeyards[turnovers][interceptions] ?></td>
                        </tr>
                        <tr>
                              <th align=center>Time of Possession</th>
                              <td align=center><?= $awaytime_possession ?></td>
                              <td align=center><?= $hometime_possession ?></td>
                        </tr>
<?
                        // since we don't have defensive stats for seasons prior to 2006-2007 (yet!),
                        // I'm going to hard-code an if statement here to only show defensive stats for
                        // 2006 season and above.
                        $start_year = substr($season, 0, 4);
                        if ($start_year >= 2006) {
?>
                              <tr>
                                    <th align=center colspan=3>Defense</th>
                              </tr>
                              <tr>
                                    <th align=center>Tackles</th>
                                    <th align=center><?= $awaydefense[tackles][number] ?></th>
                                    <th align=center><?= $homedefense[tackles][number] ?></th>
                              </tr>
                              <tr>
                                    <td align=center>Sacks/Yards</td>
                                    <td align=center><?= $awaydefense[tackles][sacks] ?>/<?= $awaydefense[tackles][sackyds] ?></td>
                                    <td align=center><?= $homedefense[tackles][sacks] ?>/<?= $homedefense[tackles][sackyds] ?></td>
                              </tr>
                              <tr>
                                    <td align=center>Tackles For Loss/Yards</td>
                                    <td align=center><?= $awaydefense[tackles][tfl] ?>/<?= $awaydefense[tackles][tflyds] ?></td>
                                    <td align=center><?= $homedefense[tackles][tfl] ?>/<?= $homedefense[tackles][tflyds] ?></td>
                              </tr>
                              <tr>
                                    <th align=center>Fumbles Forced</th>
                                    <th align=center><?= $awaydefense[fumbles][forced] ?></th>
                                    <th align=center><?= $homedefense[fumbles][forced] ?></th>
                              </tr>
                              <tr>
                                    <td align=center>Recovered/Yards</td>
                                    <td align=center><?= $awaydefense[fumbles][recovered] ?>/<?= $awaydefense[fumbles][yds] ?></td>
                                    <td align=center><?= $homedefense[fumbles][recovered] ?>/<?= $homedefense[fumbles][yds] ?></td>
                              </tr>
                              <tr>
                                    <th align=center>Interceptions</th>
                                    <th align=center><?= $awaydefense[inter][num] ?></th>
                                    <th align=center><?= $homedefense[inter][num] ?></th>
                              </tr>
                              <tr>
                                    <td align=center>Return Yards</td>
                                    <td align=center><?= $awaydefense[inter][yds] ?></td>
                                    <td align=center><?= $homedefense[inter][yds] ?></td>
                              </tr>
<? } ?>
      </table>

</center>