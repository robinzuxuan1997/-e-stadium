<html>
<?php
/*
<video width="320" height="240" controls>
<source src='/videos/2015/G6004/Q1/raw/003.mp4'type='video/mp4'>
</video>
*/
include_once("/var/estadium-football/include/Page/class_path.php");


//function playVideo(){
//"<video width="320" height="240" controls>";
//"<source src='/videos/2015/G6004/Q1/raw/003.mp4'type='video/mp4'>";
//"</video>";
//return 0;
//}


$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_venue"));
$p = new Page("web", "public", "page_dashboard");
$s = new Setup();
$s->loadCurrent();
if (isset($_REQUEST['gameid'])) {
    $gameid = $_REQUEST['gameid'];
} else{
       $gameid = $s->getActiveGameID();
}

echo nl2br("<b>First Quarter:\n</b>");



$quarter = TRUE;
$i = 1;


while($quarter == TRUE){

if($i<10){

$file = '/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q1/raw/00'.$i.'.mp4';

$ctime = filectime($file);
	if(is_int($ctime)){
	
                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":   </b>".$time." GMT ");
                //print "<button onclick='playVideo()'>Video</button>";
                print "<button type='button'>Video</button>";
	}
	else{
		$quarter = FALSE;
	}
}



else if($i<100 && $i>9){
$ctime = filectime('/var/www/backupvideos/macmini_plays/G'.$gameid.'/Q1/raw/0'.$i.'.mp4');
        if(is_int($ctime)){
                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":  </b>".$time." GMT");
                print "<button type='button'>Video</button>";
                

        }
        else{
                $quarter = FALSE;
        }
}


else if($i>99){
$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q1/raw/'.$i.'.mp4');
        if(is_int($ctime)){
                
                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.": </b>".$time." GMT");
                print "<button type='button'>Video</button>";

        }
        else{
                $quarter = FALSE;
        }

}


$i = $i+1;

}

echo nl2br("<b>\n\nSecond Quarter:\n</b>");

$i = 1;


while($quarter == TRUE){

if($i<10){

$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q2/raw/00'.$i.'.mp4');
        if(is_int($ctime)){

                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":   </b>".$time." GMT");
                print "<button type='button'>Video</button>";
        }
        else{
                $quarter = FALSE;
        }
}



else if($i<100 && $i>9){
$ctime = filectime('/var/www/html/videos/2016/G'.$gameid.'/Q2/raw/0'.$i.'.mp4');
        if(is_int($ctime)){
                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":  </b>".$time." GMT");
                print "<button type='button'>Video</button>";

        }
        else{
                $quarter = FALSE;
        }
}


else if($i>99){
$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q2/raw/'.$i.'.mp4');
        if(is_int($ctime)){

                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.": </b>".$time." GMT");
                print "<button type='button'>Video</button>";

        }
        else{
                $quarter = FALSE;
        }

}


$i = $i+1;

}

echo nl2br("<b>\n\nThird Quarter:\n</b>");


$quarter = TRUE;
$i = 1;


while($quarter == TRUE){

if($i<10){

$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q3/raw/00'.$i.'.mp4');
        if(is_int($ctime)){

                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":   </b>".$time." GMT");
                print "<button type='button'>Video</button>";
        }
        else{
                $quarter = FALSE;
        }
}



else if($i<100 && $i>9){
$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q3/raw/0'.$i.'.mp4');
        if(is_int($ctime)){
                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":  </b>".$time." GMT");
                print "<button type='button'>Video</button>";

        }
        else{
                $quarter = FALSE;
        }
}


else if($i>99){
$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q3/raw/'.$i.'.mp4');
        if(is_int($ctime)){

                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.": </b>".$time." GMT");
                print "<button type='button'>Video</button>";

        }
        else{
                $quarter = FALSE;
        }

}


$i = $i+1;

}

echo nl2br("<b>\n\nFourth Quarter:\n</b>");


$quarter = TRUE;
$i = 1;


while($quarter == TRUE){

if($i<10){

$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q4/raw/00'.$i.'.mp4');
        if(is_int($ctime)){

                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":   </b>".$time." GMT");
                print "<button type='button'>Video</button>";
        }
        else{
                $quarter = FALSE;
        }
}



else if($i<100 && $i>9){
$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q4/raw/0'.$i.'.mp4');
        if(is_int($ctime)){
                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.":  </b>".$time." GMT");
                print "<button type='button'>Video</button>";

        }
        else{
                $quarter = FALSE;
        }
}


else if($i>99){
$ctime = filectime('/var/www/backupvideos/macmini_plays/2016/G'.$gameid.'/Q4/raw/'.$i.'.mp4');
        if(is_int($ctime)){

                $time = gmdate("Y-m-d H:m:s", $ctime);
                echo nl2br("<b>\nEnd of play ".$i.": </b>".$time." GMT");
                print "<button type='button'>Video</button>";

        }
        else{
                $quarter = FALSE;
        }

}


$i = $i+1;

}
/*
<link rel="stylesheet" href="/test_timestamps.css">
<div class="wrapper">
  
  <div class="table">
    
    <div class="row header">
      <div class="cell">
        Name
      </div>
      <div class="cell">
        Age
      </div>
      <div class="cell">
        Occupation
      </div>
      <div class="cell">
        Location
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        Luke Peters
      </div>
      <div class="cell">
        25
      </div>
      <div class="cell">
        Freelance Web Developer
      </div>
      <div class="cell">
        Brookline, MA
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        Joseph Smith
      </div>
      <div class="cell">
        27
      </div>
      <div class="cell">
        Project Manager
      </div>
      <div class="cell">
        Somerville, MA
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        Maxwell Johnson
      </div>
      <div class="cell">
        26
      </div>
      <div class="cell">
        UX Architect & Designer
      </div>
      <div class="cell">
        Arlington, MA
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        Harry Harrison
      </div>
      <div class="cell">
        25
      </div>
      <div class="cell">
        Front-End Developer
      </div>
      <div class="cell">
        Boston, MA
      </div>
    </div>
    
  </div>
  
  <div class="table">
    
    <div class="row header green">
      <div class="cell">
        Product
      </div>
      <div class="cell">
        Unit Price
      </div>
      <div class="cell">
        Quantity
      </div>
      <div class="cell">
        Date Sold
      </div>
      <div class="cell">
        Status
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        Solid oak work table
      </div>
      <div class="cell">
        $800
      </div>
      <div class="cell">
        10
      </div>
      <div class="cell">
        03/15/2014
      </div>
      <div class="cell">
        Waiting for Pickup
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        Leather iPhone wallet
      </div>
      <div class="cell">
        $45
      </div>
      <div class="cell">
        120
      </div>
      <div class="cell">
        02/28/2014
      </div>
      <div class="cell">
        In Transit
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        27" Apple Thunderbolt displays
      </div>
      <div class="cell">
        $1000
      </div>
      <div class="cell">
        25
      </div>
      <div class="cell">
        02/10/2014
      </div>
      <div class="cell">
        Delivered
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        Bose studio headphones
      </div>
      <div class="cell">
        $60
      </div>
      <div class="cell">
        90
      </div>
      <div class="cell">
        01/14/2014
      </div>
      <div class="cell">
        Delivered
      </div>
    </div>
    
  </div>
  
  <div class="table">
    
    <div class="row header blue">
      <div class="cell">
        Username
      </div>
      <div class="cell">
        Email
      </div>
      <div class="cell">
        Password
      </div>
      <div class="cell">
        Active
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        ninjalug
      </div>
      <div class="cell">
        misterninja@hotmail.com
      </div>
      <div class="cell">
        ************
      </div>
      <div class="cell">
        Yes
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        jsmith41
      </div>
      <div class="cell">
        joseph.smith@gmail.com
      </div>
      <div class="cell">
        ************
      </div>
      <div class="cell">
        No
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        1337hax0r15
      </div>
      <div class="cell">
        hackerdude1000@aol.com
      </div>
      <div class="cell">
        ************
      </div>
      <div class="cell">
        Yes
      </div>
    </div>
    
    <div class="row">
      <div class="cell">
        hairyharry19
      </div>
      <div class="cell">
        harryharry@gmail.com
      </div>
      <div class="cell">
        ************
      </div>
      <div class="cell">
        Yes
      </div>
    </div>
    
 </div>
  
</div>
*/
?>
</html>



