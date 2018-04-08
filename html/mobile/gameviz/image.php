<?php
header("Content-type: image/gif");
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_drive"));

$driveid = $_GET["driveid"];
$gameid = $_GET["gameid"];
$last15 = $_GET["last15"];
$isCurrentDrive = false;

if (!Game::idExists($gameid)) {
  $setup = new Setup();
  $setup->loadCurrent();
  $gameid = $setup->getActiveGameID();
}
if (!Drive::idExists($driveid)) {
  $d = new Drive();
  $driveid = $d->findMaxDriveIndexDriveidByGameid($gameid);
}
$d = new Drive();
$currentdriveid = $d->findMaxDriveIndexDriveidByGameid($gameid);      
$isCurrentDrive = ($currentdriveid == $driveid);

$game = new Game($gameid);
$hometeam = new Team($game->getTeamID());
$awayteam = new Team($game->getVisitorID());
$home_len = strlen($hometeam->getAcronym());
$away_len = strlen($awayteam->getAcronym());

//Set the values where plays should start
//Note:  This is the North Goal Line (0)
//Adding to this will move you down.

$startx = 30;
$starty = 10;
$width  = 10;
$space  = 2;
$pxperyd= 3;
$nextplayno = 0;
$goingSouth = true;

//Create the base image.
//$im = imagecreatefromgif("field.gif"); 
$im = imagecreatefromgif("gameviz_bgfield.gif"); 

//Create some colors to use later
$blue = imagecolorallocate($im, 0, 0, 255); 
$red = imagecolorallocate($im, 255, 0, 0); 
$yellow = imagecolorallocate($im, 255, 255, 0);
$orange = imagecolorallocate($im, 255, 102, 0);
$black = imagecolorallocate($im, 0, 0, 0); 

function drawPlayOnImage($im, $ydline, $delta, $playno, $color)
{
  global $startx, $starty, $width, $space, $pxperyd, $black;
  $base_y = $starty + ($pxperyd * $ydline);
  $to_y = $starty + ($pxperyd *($delta+$ydline));
  $base_x = $startx + ($playno * ($width + $space));
  $to_x   = $base_x + $width;  
  if ($delta > 0) //gain on the play
    {
      imagefilledrectangle ($im, $base_x, $base_y, $to_x, $to_y, $color);
      imagerectangle ($im, $base_x, $base_y, $to_x, $to_y, $black);
    }
  else //this is a loss on the play
    {
      imagefilledrectangle ($im, $base_x, $to_y, $to_x, $base_y, $color);
      imagerectangle ($im, $base_x, $to_y, $to_x, $base_y, $black);
    }
} 

function runningPlay($im, $ydline, $delta, $playno)
{
  global $blue;
  drawPlayOnImage($im, $ydline, $delta, $playno, $blue);
}

function passPlay($im, $ydline, $delta, $playno)
{
  global $red;
  drawPlayOnImage($im, $ydline, $delta, $playno, $red);
}
function penaltyPlay($im, $ydline, $delta, $playno)
{
  global $yellow;
  drawPlayOnImage($im, $ydline, $delta, $playno, $yellow);
}
function drawPunt($im, $ydline, $delta, $playno)
{
  global $orange;
  drawPlayOnImage($im, $ydline, $delta, $playno, $orange);
}
function unknownPlay($im, $ydline, $delta, $playno)
{
  global $black;
  drawPlayOnImage($im, $ydline, $delta, $playno, $black);
}
function stopPlay($im, $poss, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("stop.gif"); 
  $base_y = $starty + ($pxperyd * $ydline);
  $base_x = $startx + ($playno * ($width + $space));

  if ($poss == "H")
     $base_y -= 10;

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 10, 10);
  imagedestroy($temp_img);
}

function drawDirUp($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("dir_up.gif");
  $base_y = $starty + ($pxperyd * $ydline);
  $base_x = $startx + ($playno * ($width + $space)) + 1;

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 8, 4);
  imagedestroy($temp_img);
}
function drawDirDown($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("dir_down.gif");
  $base_y = $starty + ($pxperyd * $ydline)-4;                 
  $base_x = $startx + ($playno * ($width + $space)) + 1;

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 8, 4);
  imagedestroy($temp_img);
}


function fieldGoalGood($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("fg.gif"); 
  $base_y = $starty + ($pxperyd * $ydline);
  if ($base_y > 289)
    $base_y = 289;
  $base_x = $startx + ($playno * ($width + $space));

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 11, 21);
  imagedestroy($temp_img);
}
function fieldGoalNoGood($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("fg-ng.gif"); 
  $base_y = $starty + ($pxperyd * $ydline);
  if ($base_y > 289)
    $base_y = 289;
  $base_x = $startx + ($playno * ($width + $space));

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 11, 21);
  imagedestroy($temp_img);
}
function drawTD($im, $p, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("td.gif");
  
  if($p->getHasBall() == "V")
    $base_y = 0;
  else
    $base_y = 310;
  $base_x = $startx + ($playno * ($width + $space));

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 10, 10);
  imagedestroy($temp_img);
}
function drawXP($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("xp.gif");
  
  if($ydline < 50)
    $base_y = 0;
  else
    $base_y = 310;
  $base_x = $startx + ($playno * ($width + $space));

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 11, 10);
  imagedestroy($temp_img);
}
function drawPossIcon($im, $poss)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("poss.gif");    

  if ($poss == "H")
     $base_y = 265;
  else
     $base_y = 42;
  $base_x = 220;  

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 12, 13);
  imagedestroy($temp_img);
}
function drawFG($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd;

  $temp_img = imagecreatefromgif("fgt.gif");
  
  if($ydline < 50)
    $base_y = 0;
  else
    $base_y = 310;
  $base_x = $startx + ($playno * ($width + $space));

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 10, 10);
  imagedestroy($temp_img);
}
function drawChangeOfPossDown($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd, $last15;

  if(isset($last15))
    return;

  $temp_img = imagecreatefromgif("cop_down.gif");
  $base_y = $starty + ($pxperyd * $ydline);
  if ($base_y > 289)
    $base_y = 289;
  $base_x = $startx + ($playno * ($width + $space));

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 11, 11);
  imagedestroy($temp_img);
}
function drawChangeOfPossUp($im, $ydline, $playno)
{
  global $startx, $starty, $width, $space, $pxperyd, $last15;

  if(isset($last15))
    return;

  $temp_img = imagecreatefromgif("cop_up.gif");
  
  $base_y = $starty + ($pxperyd * $ydline) - 10;
  if ($base_y > 289)
    $base_y = 289;
  $base_x = $startx + ($playno * ($width + $space));

  imagecopy($im, $temp_img, $base_x, $base_y, 0, 0, 11, 11);
  imagedestroy($temp_img);
}
function drawDir($im, $delta, $spot)
{
  global $nextplayno;
  if ($delta > 1)
    drawDirDown($im, $spot, $nextplayno);
  else if ($delta < -1)
    drawDirUp($im, $spot, $nextplayno);
}

function drawPlay($p)
{
  global $im, $nextplayno, $hometeam, $awayteam, $home_len, $away_len;
  $spot = get100YardVersion($p->getSpot());
  $delta = getSuccedingSpot($p, 0) - $spot;
  switch ($p->getType()) {
  case "P":
    if (substr_count($p->getText(), "incomplete") >0)
      {
	if (substr_count($p->getText(), "PENALTY"))
	  {
	    $arr = explode("PENALTY", $p->getText(), 2);
	    $sspot = $arr[1];
	    $arr2 = explode("to the ", $sspot, 2);
	    $sspot = substr($arr2[1], 0, 6);
	    if(substr_count($sspot, $hometeam->getAcronym()))
	      $sspot =(int)substr($arr2[1], $home_len, 2);
	    else if(substr_count($sspot, "50"))
	      $sspot = 50;
	    else
	      $sspot = 100-(int)substr($arr2[1], $away_len, 2);
	    penaltyPlay($im, $spot, $sspot-$spot, $nextplayno);
	    drawDir($im, $sspot-$spot, $sspot);
	  }
	else
	  stopPlay($im, $p->getHasBall(), $spot, $nextplayno);
      }
    else if (substr_count($p->getText(), "intercept") >0)
      {
        if($p->getHasBall() == "V")
          drawChangeOfPossDown($im, getSuccedingSpot($p, 0), $nextplayno);
        if($p->getHasBall() == "H")
          drawChangeOfPossUp($im, getSuccedingSpot($p, 0), $nextplayno);
	$nextplayno++;
      }
    else
      {
	passPlay($im, $spot, $delta, $nextplayno);
	drawDir($im, $delta, getSuccedingSpot($p, 0));
	if (substr_count($p->getText(), "PENALTY"))
	  {
	    $arr = explode("PENALTY", $p->getText(), 2);
	    $sspot = $arr[1];
	    $arr2 = explode("to the ", $sspot, 2);
	    $sspot = substr($arr2[1], 0, 6);
	    if(substr_count($sspot, $hometeam->getAcronym()))
	      $sspot =(int)substr($arr2[1], $home_len, 2);
	    else if(substr_count($sspot, "50"))
	      $sspot = 50;
	    else
	      $sspot = 100-(int)substr($arr2[1], $away_len, 2);
	    penaltyPlay($im, getSuccedingSpot($p, 0), $sspot-getSuccedingSpot($p, 0), $nextplayno);
	    drawDir($im, $sspot-getSuccedingSpot($p, 0), $sspot);
	  }
	else if(substr_count($p->getText(), "to the") > 1)
	  {
	    //Something weird happened, like a hook and ladder.
	    $arr = explode("to the", $p->getText());
	    $sspot = $arr[count($arr)-1];
	    $sspot = substr($sspot, 0, 7);
	    if(substr_count($sspot, $hometeam->getAcronym()))
	      $sspot =(int)substr($arr2[1], $home_len, 2);
	    else if(substr_count($sspot, "50"))
	      $sspot = 50;
	    else
	      $sspot = 100-(int)substr($arr2[1], $away_len, 2);

	    passPlay($im, $spot, $sspot-$spot, $nextplayno);
	    drawDir($im, $delta, $sspot);	     
	  }
      }
    break;
  case "R":
    runningPlay($im, $spot, $delta, $nextplayno);
    drawDir($im, $delta, getSuccedingSpot($p, 0));
    if (substr_count($p->getText(), "PENALTY"))
      {
	$arr = explode("PENALTY", $p->getText(), 2);
	$sspot = $arr[1];
	$arr2 = explode("to the ", $sspot, 2);
	$sspot = substr($arr2[1], 0, 6);
	if(substr_count($sspot, $hometeam->getAcronym()))
	  $sspot =(int)substr($arr2[1], $home_len, 2);
	else if(substr_count($sspot, "50"))
	  $sspot = 50;
	else
	  $sspot = 100-(int)substr($arr2[1], $away_len, 2);
	penaltyPlay($im, getSuccedingSpot($p, 0), $sspot-getSuccedingSpot($p, 0), $nextplayno);
	drawDir($im, $sspot-getSuccedingSpot($p, 0), $sspot);   
      }
    break;
  case "E":
    if (substr_count($p->getText(), "declined") > 0)
      return;
    penaltyPlay($im, $spot, $delta, $nextplayno);
        if ($delta >= 2)
          drawDirDown($im, getSuccedingSpot($p, 0), $nextplayno);
        else if ($delta <= -2)
          drawDirUp($im, getSuccedingSpot($p, 0), $nextplayno);
    break;
  case "F":
    if(substr_count($p->getText(), "MISSED") > 0)
      fieldGoalNoGood($im, $spot, $nextplayno);
    else if(substr_count($p->getText(), "BLOCKED") > 0)
      {
         fieldGoalNoGood($im, $spot, $nextplayno);
	 $arr = explode("recovered by ", $p->getText(), 2);
         $rec_by = substr($arr[1], 0, 4);
         if(substr_count($rec_by, $hometeam->getAcronym()) && $p->getHasBall() == "V")
           drawChangeOfPossDown($im, getSuccedingSpot($p, 0), $nextplayno+1);
         if(substr_count($rec_by, $awayteam->getAcronym()) && $p->getHasBall() == "H")
           drawChangeOfPossUp($im, getSuccedingSpot($p, 0), $nextplayno+1);
	 $nextplayno++;
      }
    else
      {
	fieldGoalGood($im, $spot, $nextplayno);
	drawFG($im, $spot, $nextplayno);
      }
    break;
  case "X":
    if(substr_count($p->getText(), "failed") > 0)
      fieldGoalNoGood($im, $spot, $nextplayno);
    else
      {
	fieldGoalGood($im, $spot, $nextplayno);
	drawXP($im, get100YardVersion($p->getSpot()), $nextplayno);
      }
    break;
  case "U":
    drawPunt($im, $spot, $delta, $nextplayno);
    drawDir($im, $delta, getSuccedingSpot($p, 0));
    if($p->getHasBall() == "V")
      {
	if (getSuccedingSpot($p, 0) == 0)
	  drawChangeOfPossDown($im, 20, $nextplayno+1);
	else
	  drawChangeOfPossDown($im, getSuccedingSpot($p, 0), $nextplayno+1);
	$nextplayno++;
      }
    else
      {
	if (getSuccedingSpot($p, 0) == 100)
	  drawChangeOfPossUp($im, 80, $nextplayno+1);
	else
	  drawChangeOfPossUp($im, getSuccedingSpot($p, 0), $nextplayno+1);
	$nextplayno++;
      }
    return;
  case "K":
  case "#":
  case NULL:
    //don't draw kickoffs or punts  or clock.
    return;
  default:
    unknownPlay($im, $spot, $delta, $nextplayno);
  }
  //lostfumble
  if (substr_count($p->getText(), "fumble") >0)
    {
      $arr = explode("recovered by ", $p->getText(), 2);
      $rec_by = substr($arr[1], 0, 4);
      if(substr_count($rec_by, $hometeam->getAcronym()) && $p->getHasBall() == "V")
	{
	  drawChangeOfPossDown($im, getSuccedingSpot($p, 0), $nextplayno+1);
	  $nextplayno++;
	}
      if(substr_count($rec_by, $awayteam->getAcronym()) && $p->getHasBall() == "H")
	{
	  drawChangeOfPossUp($im, getSuccedingSpot($p, 0), $nextplayno+1);
	  $nextplayno++;
	}
    }
  //Touchdown
  if (substr_count($p->getText(), "TOUCHDOWN") >0)
    {
      drawTD($im, $p, $nextplayno);
    }
  $nextplayno++;
}

function canRenderPlay($p)
{
  switch($p->getType())
    {
    case "P": //PASS
    case "R": //RUN
    case "E": //PENALTY
    case "F": //FIELD GOAL
    case "X": //EXTRA POINT
    case "U": //PUNT
      return true;
      
    case "K": //KICKOFF
    case "#": //TIMING
    case NULL:
    default:
      return false;
    }
}

function get100YardVersion($spot)
{
  if (substr_count($spot, "H")>0)
    return (int)substr($spot, 1);
  if (substr_count($spot, "V")>0)
    return 100 - (int)substr($spot, 1);
  if (substr_count($spot, "50")>0)
    return 50;
  return -1;
}
      
function getSuccedingSpot($p, $last)
{
  global $hometeam, $awayteam, $home_len, $away_len;
  $arr = explode("to the ", $p->getText());
  $sspot = substr($arr[1], 0, 7);
  if(substr_count($sspot, $hometeam->getAcronym()))
    return (int)substr($arr[1], $home_len, 2);
  if(substr_count($sspot, $awayteam->getAcronym()))
    return 100-(int)substr($arr[1], $away_len, 2);
  if(substr_count($sspot, "50"))
    return 50;
  if (substr_count($p->getText(), "incomplete") > 0)
    return get100YardVersion($p->getSpot());
  else
    return 100-(int)substr($arr[1], $away_len, 2);
}

function drawFirstDownLine($isCurrentDrive, $p)
{
  global $im, $yellow, $blue, $startx, $starty, $pxperyd;
  if(! $isCurrentDrive || $p->getType()=="F" ||
     $p->getType()=="X")
     return;
  
  $spot = get100YardVersion($p->getSpot());
  $sspot= getSuccedingSpot($p, 0);
  $arr = explode("& ", $p->getText(), 2);
  $linetogain = substr($arr[1], 0, 4);
  if ($linetogain == "GOAL")
  {
    $fdspot = 310;
    if ($p->getHasBall == "V")
       $fdspot = 10;
  }
  else
  {
    $linetogain = (int) $linetogain;
    if (substr_count($p->getText(),"1ST DOWN"))
    { 
       $linetogain = 10;
       if ($p->getHasBall() == "V")
          $linetogain *= -1;
       $fdspot = $starty + ($sspot + $linetogain) * $pxperyd;
    }        
    else
    {
       if ($p->getHasBall() == "V")
          $linetogain = (int) $linetogain * -1;
       $fdspot = $starty + ($spot + $linetogain) * $pxperyd;
    }
  }
  if($p->getType() == NULL || $p->getType() == "#")
    $los = $starty + $spot * $pxperyd;
  else 
    $los = $starty + $sspot * $pxperyd; 

  imagefilledrectangle ($im, $startx-4, $los, 234, $los+1, $blue);
  imagefilledrectangle ($im, $startx-4, $fdspot, 234, $fdspot+1, $yellow);
}

$stack = array();
$p = new Play();
$x = $p->findPlaysByGameID( $gameid );
$d = new Drive($driveid);
$driveindex = $d->getDriveIndex();

if(isset($last15))
  {
    $count = 0;
    while($p = $x->getOne())
      {
	if(canRenderPlay($p) && count($stack) < 15)
	  {
	    array_push($stack, $p);
	    $count++;
	  }
      }
    array_reverse($stack);
  }
else
  {
    while ($p = $x->getOne())
      {  
	if ($p->getDriveNo() == $driveindex) // && $p->getType() != NULL)
	  {
	    array_push($stack, $p);
	  }
      }
  }

if(count($stack) > 0)
   drawFirstDownLine($isCurrentDrive, $stack[0]);    



while(count($stack) > 0)
  {   
   $p = array_pop($stack);
   
   if (count($stack) == 0)
      drawPossIcon($im, $p->getHasBall());
   
   if ($nextplayno != 0)
     if($lastHasBall != $p->getHasBall() && isset($last15))
       {
	 $vline = $startx + $nextplayno*($width+$space);
	 imagefilledrectangle ($im, $vline-1, 10, $vline-1, 310, $black);
       }
   $lastHasBall = $p->getHasBall();
     
   drawPlay($p);
  }

imagegif($im);
imagedestroy($im);
?> 
