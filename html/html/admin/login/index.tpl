<?
$p->startTemplate();
?>
<br>
<h1>Welcome, <?=$name?></h1>

<?if (strlen($msg) > 0) echo $msg . "<br>";?>
<hr>
<h3>Administrative Tools</h3>
<a href="<?=$path->getPath("page_admin_bios")?>">Staff/Player Update</a><br>
<a href="<?=$path->getPath("page_admin_video_assoc")?>">Video/Play Associations</a><br>
<a href="<?=$path->getPath("page_admin_monitor_home")?>">Purdue System Monitor</a><br>
<a href="<?=$path->getPath("page_admin_monitor_away")?>">Visitor System Monitor</a><br>
<hr>
<br>
<?
$p->close();
?>
