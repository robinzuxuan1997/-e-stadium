<?php
function open_db(){
    if(!($dbpipe = mysqli_connect("localhost","estad","V!p_f09","estadium"))){
        echo "Failed to connect to the database";
    }
    return($dbpipe);
}

//A function from stackoverflow to generate downloadable csv type file using HTTP header
function download_csv_results($results, $name = NULL)
{
    if( ! $name)
    {
        $name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.csv';
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='. $name);
    header('Pragma: no-cache');
    header("Expires: 0");

    $outstream = fopen("php://output", "w");

    foreach($results as $result)
    {
        fputcsv($outstream, $result);
    }

    fclose($outstream);
}



$dbpipe = open_db();
$tmstamp = "";
$count = 0;

    $gameid = $_POST['gameidsearch'];
    if($gameid=="") {
        echo "No game selected.<br>";
        return;
    }
    else if($gameid!="")
    {
        
        //$quarterSelected = $_POST['quarterselected'];
        $yearSelected = @$_POST['yearSelected'];
        if(!$yearSelected) {
			$yearSelected = (int)@date("Y");
		}
        //make an array to store the csv to be exported
        $csvAllQuarters = array();
        
        $quarter = 1;
        //loop through quarters
        while ($quarter <= 4) {
            //echo nl2br("\n\n<b>Quarter ".$quarter."\n</b>");
            $done = FALSE;
            $i = 1;
            //gives proper filename based on the number of digits of i (00x.mp4, 0xx.mp4, xxx.mp4... that's how our videos get named')
            
            //make an array to store the information from this quarter
            $csvThisQuarter = array();
            
            //It is assumed that we won't have 1000+ video clips in a same quarter (I think it is reasonable...)
            while ($done == FALSE) {
                if ($i <= 9) {
                    $name = '00'.$i;
                } else if ($i <= 99 && $i > 9) {
                    $name = '0'.$i;
                } else if ($i > 99) {
                    $name = $i;
                }
                
                
                // variables here:
                // $gameid: gameid
                // $quarter: quarter
                // $name: filename (without .mp4), like 001, 011...
                // $timeinsecs: epoch time of start time (end time - duration)
                // $starttime: starttime
                // $durationtime: duration
                // $time: end time (file creation time)
                // $mtime: epoch time of end time (file creation time)
                // $description
                
                date_default_timezone_set('America/New_York');
                $file = '/var/videos/'.$yearSelected.'/G'.$gameid.'/Q'.$quarter.'/raw/'.$name.'.mp4';
                $mtime = @filemtime($file);
                
                //Grab the return string of ffmpeg command as duration
                $duration=substr(shell_exec("/usr/local/bin/ffmpeg -i '".$file."' 2>&1 | grep 'Duration'"), 12, 8);
                if(is_int($mtime)) {
                    $time = strftime("%Y-%m-%d %H:%M:%S", $mtime);
                    $durationinsecs = substr($duration,0,2)*3600+substr($duration,3,2)*60+substr($duration,6,2);
                    $timeinsecs = strtotime($time) - $durationinsecs;
                    $starttime = new DateTime("@$timeinsecs");
                    //For unknown reason need to set timezone again here to get a correct result
                    $starttime->setTimezone(new DateTimeZone('America/New_York'));
                    //echo nl2br("<b>\n ".$name.".mp4:  Start Time: </b>".$starttime->format('Y-m-d H:i:s')." <b>Start Time (Epoch): </b>".$timeinsecs." <b>Duration: </b>".$duration." <b>End Time: </b>".$time."<b> End time (Epoch): </b>".$mtime);
                    $sql = "SELECT PlayText FROM Video WHERE GameID='{$gameid}' AND VideoFileName='{$name}' AND Quarter={$quarter}";
                    $description = "";//mysqli_fetch_array(mysqli_query($dbpipe,$sql))[0];
                    //printf ("  <b>Description: </b>%s",$description);
                    //printf ("<a href=%s>Video</a>", '/videos/2016/G'.$gameid.'/Q'.$quarter.'/raw/'.$name.'.mp4');
                    $starttime_tmp = $starttime->getTimestamp();

                    // update starttime epoch and endtime
                    $sql = "UPDATE `Video` SET FileCreationTime='{$time}', StartTimeEpoch='{$starttime_tmp}', EndTime='{$mtime}' WHERE GameID='{$gameid}' AND VideoFileName='{$name}' AND Quarter={$quarter}";
					$tmstamp = $tmstamp.$starttime_tmp." ~ ".$mtime."<br>";
                    mysqli_query($dbpipe,$sql);
                    //populate the array
                    //array_push($csvThisQuarter,array($gameid, $quarter, $name.".mp4",$starttime->format('Y-m-d H:i:s'), $timeinsecs, $duration, $time, $mtime, $description));
                    $count++;
                } else {
                    $done = TRUE;
                    $quarter = $quarter + 1;
                }
                
                

                
                $i = $i + 1;
            }
            
            //populate the global array
            array_push($csvAllQuarters, $csvThisQuarter);
        }
    }


mysqli_close($dbpipe);

if ($count == 0) {
	echo "Video Files for given game id and year are not found.";
} else {
	echo "Successfully updated following timestamps:<br>";
	echo $tmstamp;
}

// ob_flush();
// flush();

// $quarterCounter = 0;
// foreach ($csvAllQuarters as $eachQuarter)
// {
//     $quarterCounter = $quarterCounter + 1;
//     $filename = "G".$gameid."Q".$quarterCounter.".csv";
//     download_csv_results($eachQuarter, $filename);
//     exit();
// }

//Only returns selected quarter's csv. Not a beautiful implementation but it works for now...
//$filename = "G".$gameid."Q".$quarterSelected.".csv";
//download_csv_results($csvAllQuarters[$quarterSelected-1], $filename);
//exit();


?>

</html>
