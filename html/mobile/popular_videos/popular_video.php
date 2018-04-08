<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_popular_video"));

$p = new Page("mobile", "public", "page_popular_video");

$DateTime = date("m/d/Y 00:00:01.000");
$popular_video = new Popular_Video($DateTime);
$num_popular_videos = 5;

$p->startTemplate(true);
?>
<center><font class="mobile_h1">Most Popular Videos<hr></font></center>
<center><font class="normal">Videos &nbsp; &nbsp; &nbsp; &nbsp; No. Accessed<br></font>
<?
$video_count = 1;
while($video_count <= $num_popular_videos && $clip = $popular_video->db->getRowArray())
{
	//$str = "rtsp://estadiumvideo.purdue.edu/estadium/2005/G1/Q4/005.wmv";
	$temp_array = explode('/', $clip["Clip"]);
	$size = count($temp_array);
	if($size >= 4)
	 $videofile = $temp_array[$size-4]."/".$temp_array[$size-3]."/".$temp_array[$size-2]."/".$temp_array[$size-1];
	$linkpath = $path->getPath("link_video_basedir") . $videofile;
?>

<a class="normal" href="<?=$linkpath?>">Video <?=$video_count?></a>
<font class="normal">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<?=$clip["ClipCount"]?>
<br></font>
<?
$video_count++;
}?>
</center>

<?
$p->close();
?>
