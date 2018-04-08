<?
include_once('phpweatherlib.php'); 
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));

$p = new Page("mobile", "public", "page_lines");

$p->startTemplate();
$fh = fopen("../../../../senior_design/blobs.txt", "r");
$blobs = fread($fh, 2);
fclose($fh);
//These offsets were for the Duke game

$scorediffoffset = (-2); 
$qtroffset = 1;
$gametimeoffset = 2;
$waittime = (round(20*($blobs/3))) + $qtroffset + $scorediffoffset + $gametimeoffset;

$waitsecs = $waittime % 60;
if ($waitsecs == 1) {
$waitsecstext = "second";
}
else if ($waitsecs == 0) {
$waitsecstext = "";
$waitsecs = "";
}

else{
$waitsecstext = "seconds";
}

$waitmins = ($waittime-$waitsecs)/60;
if ($waitmins == 1) {
$waitminstext = "minute";
}
else if ($waitmins == 0) {
$waitminstext = "";
$waitmins = "";
}

else{
$waitminstext = "minutes";
}



$secondtimenow = date('s',time(now));
if ($secondtimenow<30){
$secondsupdated = '00';
}
else {
$secondsupdated = '30';
}
if ($blobs<3){
$waitsecs = "";
$waitsecstext = "None";
$peoplelowerlimit = 0;
}
else {
$peoplelowerlimit = (round($blobs/3))-1;
}

?>
<center><font class="mobile_h1">West Concession Stand 2 <br></font></center><br>
<center><a class="small" href="<?=$path->getPath("page_lines")?>">Refresh</a></center><br>
<center>
<h3>
<br>
There are currently <?echo $peoplelowerlimit;?> - <?echo ((round($blobs/3))+1);?> people in each line (out of 3) at this concession stand.
<br>
<br>
Your wait time is approximately:
</h3>

<h2> <?echo $waitmins;?> <?echo $waitminstext;?> <?echo $waitsecs;?> <?echo $waitsecstext;?> </h2>

<br>
Page updated <?echo date('l M jS Y g:i:', time(now));?>
<?echo $secondsupdated;?>
<?echo date('A', time(now));?>
<?
$p->close();
?>
