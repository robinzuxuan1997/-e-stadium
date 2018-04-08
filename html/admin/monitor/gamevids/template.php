<style type="text/css">
      div.links{
            width: 180px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
      }

      div.thiscontent a{
            color: white;
      }

</style>
<script type="text/javascript">
      $(document).ready(function(){
            $('div#videos_content li.arrow a').click(function(){
                  link = $(this).attr("href");

                  $('div#videos_content').html($('<div><img src="/images/loading.gif"></div>').load(link));
            });

            $('div#videos_content a.video img').click(function(){
                  this.parent.click();
            });

      })

</script>

<div class="thiscontent">
      <marquee><small><center>Scroll down to watch videos | brought to you by <a href="http://www.bankofamerica.com" target="_blank">BANK OF AMERICA</a></center></small></marquee>
      <?if (!is_array($quarters) || count($quarters) < 1) {?>
      No highlights are available at this time.
            <?} else {
            if (count($quarters) > 4) {?><font class="mobile_h1"><br></font><?}?>


      <ul class="rounded">


                  <?for($i=0; $i<count($quarters); $i++) {
                        if($i+1 != $quarter) {

                              ?>

            <li  class="arrow"><a href="<?=$p->pageName()?>?gameid=<?=$gameid?>&quarter=<?=$quarters[$i]?>">Quarter <?=$quarters[$i]?></a></li>

                              <?}
                  }
                  ?>

      </ul>


      <ul class="rounded"><li>Videos for Quarter <?=$quarter?></li></ul>


      <table border=0 width="100%">
            <tr>
                  <th>&nbsp;Angle&nbsp;</th>
                  <th>Description</th>
            </tr>
                  <?foreach($videos as $angles) {?>
            <tr>

                  <td class="video_link">
                                    <?foreach($angles as $v) {?>
                        <a target="_blank" class="video" href="<?=Check::constructVideoLink($v[path], $v[filename])?>"><img src="/images/video_Icon.png" alt=""><?=$v[anglenumber]?></a><br>
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
            <?}?>
</div>
