<?php
//include('../../mobile_device_detect.php');
//mobile_device_detect('http://estad4.vip.gatech.edu/iphone',true,true,true,true,true,'http://estad4.vip.gatech.edu/mobile',false);


include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_page"));

// Setup Page
$p = new Page("mobile", "public", "page_other_scores");
$p->startTemplate();



//RSS Feed to get other sports
?>
<center>
<font size="2"><b> Other Scores </b> </font>
<form method="post" name="Score">
<select name="scores" onchange="Score.submit();">
<option value="select">Please Select</option>
<option value="mlb">MLB</option>
<option value="nba">NBA</option>
<option value="ncf">NCAA Football</option>
<option value="nfl">NFL</option>
<option value="nhl">NHL</option>
</select></form>
</center>
<?

$sport = $_POST['scores']; 
if ($sport=='ncaaf'){
include ("/www/html/mobile/other_stats/ncaa_index.php");
}
else{
function get_content($url)
{
   $ch = curl_init();

   curl_setopt ($ch, CURLOPT_URL, $url);
   curl_setopt ($ch, CURLOPT_HEADER, 0);

   ob_start();

   curl_exec ($ch);
   curl_close ($ch);
   $string = ob_get_contents();

   ob_end_clean();
  
   return $string;   
} 


echo "<html>";
	
$content = get_content ("http://sports.espn.go.com/".$sport."/bottomline/scores");

$content_array=explode("&", $content);
$scorearray = array();
$i=0;
$j=0;
foreach($content_array as $content) {
	if (strpos($content, "_left")) {
		$equalpos = strpos($content, "=");
		$end = strlen($content);		
		$quarter[$i]=$matches[0];
		$title = substr($content, ($equalpos+1), $end);
		$title = str_replace("^", "", $title);
		$title = str_replace("%20%20%20", "<br>", $title);
		$title = str_replace("%20at%20", "<br>", $title);
		$title = str_replace("%20", " ", $title);
		$title = str_replace("%26", "&", $title);
		$title = preg_replace("/\(([^)]{3,})\)/", "<td width=180><b>$1</b></td>", $title);
		
		
		$scorearray[$i]["title"] = $title;

	}
	if (strpos($content, "_url")) {
		$equalpos = strpos($content, "=");
		$end = strlen($content);
		$url = substr($content, ($equalpos+1), $end);
		$url = str_replace("^", "", $url);
		$url = str_replace("%20", " ", $url);
		


		$scorearray[$i]["url"] = $url;
				$i++;

	}
}
if ($sport=="ncf"){
echo "<center>";

/////////////////////////////////////////////////////////Top 25:
echo "<table>";

echo "<b><br>Top 25</b><br><br>";
foreach($scorearray as $score) {

if($j%2==0){
		$bgcolor="DDDDDD";
		
	} else {
		$bgcolor ="FFFFFF";
		
	}

if (preg_match("/\([0-9]|[0-9][0-9]\)/", $score[title])) {


echo "<tr style='background-color:" .$bgcolor."'>";
$j++;
echo "<td width=180>";
if (preg_match("/Georgia Tech/", $score[title])) {
 $j--;   
}
else{

	echo "<b>".$score["title"]."</b>\n";
		echo "</td>\n";



echo "</tr>\n";

}}}
echo "</center>";

echo "</table>\n";

////////////////////////////////////////////////////////////////////////////Not Top 25
echo "<center>";
echo "<table>";
echo "<br>";
echo "<b><br>Other Teams</b><br><br>";
foreach($scorearray as $score) {

if($j%2==0){
		$bgcolor="DDDDDD";
		
	} else {
		$bgcolor ="FFFFFF";
		
	}

if (!preg_match("/\([0-9]|[0-9][0-9]\)/", $score[title])) {


echo "<tr style='background-color:" .$bgcolor."'>";
$j++;
echo "<td width=180>";
if (preg_match("/Georgia Tech/", $score[title])) {
 $j--;   
}
else{


	echo "<b>".$score["title"]."</b>\n";
		echo "</td>\n";



echo "</tr>\n";

}}}
echo "</center>";

echo "</table>\n";
}
else{
echo "<center>";
echo "<table>";

foreach($scorearray as $score) {

if($j%2==0){
		$bgcolor="DDDDDD";
		
	} else {
		$bgcolor ="FFFFFF";
		
	}



echo "<tr style='background-color:" .$bgcolor."'>";
$j++;
echo "<td width=180>";


	echo "<b>".$score["title"]."</b>\n";
		echo "</td>\n";



echo "</tr>\n";

}
echo "</center>";

echo "</table>\n";
}
echo "</html>\n";

}

?>


<?php
// Close Page
$p->close();
?>
