<?php
require '../../jsonwrapper/jsonwrapper.php';

$sport = $_REQUEST['scores'];

if ($sport=='ncaaf'){
	
} else {
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
	$content = get_content("http://sports.espn.go.com/".$sport."/bottomline/scores");
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
			
			//echo "title: $title\n";
			//$scorearray[$i]["title2"] = $title;
			
			$title = str_replace("%20", " ", $title);
			$title = str_replace("%26", "&", $title);
			
			$tokens = preg_split("/   /",$title);
			if (sizeof($tokens)==1){
				$tokens = preg_split("/ at /", $title);	
			}
			$team1 = $tokens[0];
			$team2 = $tokens[1];
			
			preg_match("/\(([^)]{3,})\)/", $team2, $matches);
			$result = $matches[1];
			
			$team2 = preg_replace("/\ *\(([^)]{3,})\)/","",$team2);
			
			//$title = str_replace("%20%20%20", "|", $title);
			//$title = str_replace("%20at%20", "=", $title);
			
			//$title = preg_replace("/\(([^)]{3,})\)/", "<td width=180><b>$1</b></td>", $title);
			//preg_match('@^(?:http://)?([^/]+)@i',
    			//"http://www.php.net/index.html", $matches);
			//$host = $matches[1];
			
			//echo "Result: $result\n";
			
			$title = preg_replace("/\(([^)]{3,})\)/", "[$1]", $title);
			
			
			//$scorearray[$i]["title"] = $title;
			$scorearray[$i]["team1"] = $team1;
			$scorearray[$i]["team2"] = $team2;
			$scorearray[$i]["result"] = $result;
	
		}
		if (strpos($content, "_url")) {
			$equalpos = strpos($content, "=");
			$end = strlen($content);
			$url = substr($content, ($equalpos+1), $end);
			$url = str_replace("^", "", $url);
			$url = str_replace("%20", " ", $url);

			$scorearray[$i]["url"] = $url;
					$i++;
				
			//echo "Scorearrray $i = $title  --  $url<br/>\n";
		}
	}
	$data = array('scores'=>$scorearray);
	echo json_encode($data);
}
/*



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

*/	
?>
