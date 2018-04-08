<?
$p->startTemplate();
?>

<center><font class="mobile_h1"><u>'Ask the Coach' Answers</u><br>
                                   from Coach Tiller's Show<br></font></center>
<form name="episodeForm" action="<?=$p->pageName()?>" method="POST">
<center><?$p->displayVar("episodeid")?><?$p->displayVar("submit1")?></center>
<?$p->displayVar("season");?>
<?$p->displayVar("type");?>
</form>
<?if (strlen($errmsg) > 0) {?>
  <center><font color=red><?=$errmsg?><br></font></center> 
<?} else {?>
  <hr>
  <center>
    <b>PUR vs. <?=$awayacr?>: <?=$gamedate?></b><br>
    <u>Episode <?=$episode_num?></u><br>
  </center>
  <?if (!is_array($videos)) {?><center>There are no videos available at this time.</center>
  <?} else {?>
    <table border=0 width=100%>
      <tr>
        <th>Video</th>
        <th>Question</th>
      </tr>
    <?foreach($videos as $v) {?>
      <? $person = preg_replace("/:.*$/", "", $v[desc]); $question = preg_replace("/^[^:]*:?/", "", $v[desc]); ?>
      <tr>
        <td align=center
            onClick="location.href='<?=($path->getPath("link_video_basedir") . $v[file])?>';"
            onMouseOver="this.style.cursor='hand';"
            onMouseOut="this.style.cursor='default';">
          <a href="<?=($path->getPath("link_video_basedir") . $v[file])?>"><img border=0 src="<?=$path->getPath("image_camera_icon")?>"></a>
        </td>
        <td><b><u><?=$person?>:</u></b> <?=$question?></td>
      </tr>
    <?}?>
    </table><br>
  <?}?>
<?}?>
    
<?
$p->close();
?>
