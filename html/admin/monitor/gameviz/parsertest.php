<?php
//QB Sack - 7552
//2PT Convert Good - 
//2PT Convert No Good -
//XP Good - 
//XP No Good - 
//Field Goal Good - 
//Field Goal No Good - 7534 
//Punt - 7540

// 7516 - Multi-Tackle (explode on semicolon ";")
//      - Penalty type listed between Team acronym and right parenthesis "("
//      - Offending Player listed after last "("

include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_drive"));
include_once($path->getFilePath("class_play"));
include_once($path->getFilePath("class_viz_field"));
include_once($path->getFilePath("class_team"));
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_style"));
include_once($path->getFilePath("class_viz_play"));

class Parser{

  var $theRawText;
  var $thePlayType;
  var $hasTheBall;

  function Parser(){}
//header('Content-type: application/xml; charset="utf-8"',true);

  function getPlayType(){return $this->thePlayType;}
  function getRawText(){return $this->theRawText;}
  function getWhoHasBall(){return $this->hasTheBall;}

function getPlayText($id){
//////////////////////////////////////////////////
// Register Form variables
//////////////////////////////////////////////////

//$playid = $_GET["playid"];
$playid = $id;
//////////////////////////////////////////////////
// Start template
//////////////////////////////////////////////////

$stack = array();
 
if(isset($playid)){
  $p = new Play($playid);
  $game = new Game($p->getGameID());
}
else{
  $p = new Play();
  $setup = new Setup();
  $setup->loadCurrent();
  $gameid = $setup->getActiveGameID();
  $x = $p->findPlaysByGameID( $gameid );
  $p = $x->getOne();
}

$a = array();
if (!$a[width])  $a[width] = 240;
if (!$a[height]) $a[height] = 320;
if (!$a[orient]) $a[orient] = "portrait";
if (!Game::idExists($a[gameid])) {
  $setup = new Setup();
  $setup->loadCurrent();
  $a[gameid] = $setup->getActiveGameID();
}
$a[game] = new Game($a[gameid]);

$f = new VizField($a);

$vp = new VizPlay($p, $f);
$type = $vp->info[type];
$typeModifier = $vp->info[type_modifier];
$rawText = $vp->info[text];
$result = $vp->info[result];

$this->thePlayType = $type;
$this->theRawText = $rawText;
/*
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

?>
<play>
  <id><?=$vp->getID()?></id>
  <possession><?=$vp->getHasBall()?></possession>
<?
*/

//$outText = $vp->getText();
//[Who has the ball] [net yards] [type of play]. [type modifier] [result]

//Figure out who has the ball
if($vp->getHasBall()=="H"){
  $team = new Team($game->getTeamID());
  $otherTeam = new Team($game->getVisitorID());
  $homeHasBall = true;
  $this->hasTheBall = "HOME";
}
elseif($vp->getHasBall()=="V"){
  $team = new Team($game->getVisitorID());
  $otherTeam = new Team($game->getTeamID());
  $homeHasBall = false;
  $this->hasTheBall = "VISITOR";
}
else{
}

$start_spot = $vp->info[start_spot];
$end_spot = $vp->info[end_spot];

//echo $start_spot;
//echo $end_spot;

//strip 0's from front of numbers
//silly stats guys...
if(strlen($start_spot)>1){
  $start_spot = preg_replace("/^0+/", $start_spot);
}
if(strlen($start_spot)>1){
  $end_spot = preg_replace("/^0+/", $end_spot);
}


$yards = $start_spot - $end_spot;
if($yards>0){
  $gain = true;
}
elseif($yards<0){
  $gain = false;
}
else{
  $gain = false;
}

//set first thing in outText to team Acronym
$outText = $team->getAcronym() . " ";

switch($type){
  case "PASS":
    //Apparently they label QB sacks as PASSES...
    if(preg_match('/sacked/',$rawText)){
      $qb = getColonName($rawText);
      $sacker = getEndName($rawText);

      $outText .= abs($yards) . " yd LOSS, $qb SACKED by $sacker";
      //$outText .= "$qb Sacked By $sacker. For A Loss of ". abs($yards) . " Yards.";
    }
    //IF THE PLAY WAS NOT A SACK
    else{
      //going with text if we can...don't trust the stats numbers
      if(preg_match('/for no gain/',$rawText)){
        $yards=0;
        $gain = false;
      }
      //IF PASS WAS INTERCEPTED
      if($typeModifier=="INTERCEPTED"){
        $qb = getColonName($rawText);
        $interceptor = getInterceptorName($rawText);
        
        if(preg_match('/return [\d]+ yards/',$rawText)){
          $return = strpos($rawText,"return ");
          $returnedYards = substr($rawText,($return+7),3);
          while(preg_match('/[^0-9]/',$returnedYards)){
            $returnedYards = substr($returnedYards,0,(strlen($returnedYards)-1));
          }
        }
        
        $outText .= "PASS by $qb INTERCEPTED by $interceptor";
        if($result=="TOUCHDOWN"){
          $outText .= ", " . $otherTeam->getAcronym() . " TOUCHDOWN";
        }
        else{
          $outText .= ", " . $otherTeam->getAcronym() . " $returnedYards RETURN";
        }
      }
      //IF NOT INTERCEPTED
      else{
        //if incomplete pass
        if($typeModifier=="INCOMPLETE"){
          $qb = getColonName($rawText);
          $incompleteTo = strpos($rawText,"incomplete to");
          $receiverName = substr($rawText,$incompleteTo);
          $endOfName = strpos($receiverName,",");
          $receiverName = substr($receiverName,13,($endOfName-13));
          $receiverName = toTitleCase($receiverName);
     
          //$outText .= toTitleCase($typeModifier . " " . $type) . " ";
          $outText .= "INCOMPLETE PASS by $qb intended for $receiverName";
          //$outText .= "intended for $receiverName";
        }
        //COMPLETE PASS OR NO MODIFIER
        else{
          $qb = getColonName($rawText);
          $receiver = getCompletedTo($rawText);

          if($gain){
            //IF PLAY RESULTED IN A TOUCHDOWN
            if($result=="TOUCHDOWN"){
              $outText .= "$yards yd TOUCHDOWN PASS by $qb to $receiver";
            }
            else{
              $outText .= "$yards yd PASS by $qb to $receiver";
            }
          }
          else{
            if($yards!=0){
              $outText .= "$qb: PASS. ". abs($yards) . " yd LOSS.";
            }
            else{
              $outText .= "$qb: PASS. NO GAIN.";
            }
          }//END NO GAIN
        }//END COMPLETE
      }//END NOT INTERCEPTED
    }//END NOT SACK

    if($result=="PENALTY"){
      $outText .= ", PENALTY";
    }
    
    break;// END OF PASS*****************************
  case "RUSH":
      $carrier = getColonName($rawText);

    if($gain){
        //$outText .= "$carrier: $yards yd RUSH.";

        //IF PLAY RESULTED IN A TOUCHDOWN
        if($result == "TOUCHDOWN"){
          $outText .= "$yards yd TOUCHDOWN RUSH by $carrier"; 
        }
        else{
          $outText .= "$yards yd RUSH by $carrier";
        }
    }
    else{
      if($yards!=0){
        $outText .= abs($yards) . " yd LOSS on RUSH by $carrier";
        //$outText .= "$carrier: RUSH. " . abs($yards) . " yd LOSS";
      }
      else{
        $outText .= "NO GAIN on RUSH by $carrier";
      }
    }
    break;//END OF RUSH*****************************
  case "PENALTY":
    break;//END OF PENALTY*****************************
  case "FIELD GOAL":
        $kicker = getColonName($rawText);
        $distance = getAttemptDistance($rawText);

        if($result=="GOOD"){
          $outText .= "$distance yd FIELD GOAL by $kicker is GOOD";
        }
        else{
          $outText .= "$distance yd FIELD GOAL by $kicker is NO GOOD";
        }

        if(preg_match('/wide/',$rawText)){    
          $direction = getWideDirection($rawText);
          $outText .= ", WIDE " . strtoupper($direction);
        }
        else{
          $outText .= ".";
        }

    break;//END OF FIELD GOAL*****************************
  case "EXTRA POINT":
      if(preg_match('/kick attempt/',$rawText)){
        $kicker = getColonName($rawText);
        
        if($result=="GOOD"){
          $outText .= "EXTRA POINT by $kicker is GOOD";
        }
        //if result is no good
        else{
          $outText .= "EXTRA POINT by $kicker is NO GOOD";
        }
      }

      if(preg_match('/pass attempt to/',$rawText)){
        $receiver = getPassAttemptTo($rawText);
        $qb = getColonName($rawText);

        //if result is good
        if($result=="GOOD"){
          $outText .= "$qb: PASS to $receiver. TWO POINT CONVERSION GOOD.";
        }
        else{
          $outText .= "$qb: PASS ATTEMPT to $receiver. TWO POINT CONVERSION NO GOOD.";
        }
      }
    break;//END OF EXTRA POINT*****************************
  case "PUNT":
    
    $kicker = getColonName($rawText);

    /*
    $start = strpos($rawText,":");
    $endOfName = strpos($rawText,",");
    $kickerName = trim(substr($rawText,($start+1),($endOfName - $start - 1)));
    $kickerName = toTitleCase($kickerName);
*/

    $outText .= "$yards yd PUNT by $kicker";

    if(preg_match('/fair catch by/',$rawText)){
      $catcher = getFairCatcher($rawText);
      $outText .= ", ". $otherTeam->getAcronym() . " FAIR CATCH";
    }

    if(preg_match('/downed/',$rawText)){
      $outText .= " is DOWNED";
    }
    if(preg_match('/touchback/',$rawText)){
      $outText .= " results in TOUCHBACK";
    }

    break;//END OF PUNT*****************************
  case "KICKOFF":
    //end_spot will be -1 on kickoffs!
    $kicker = getColonName($rawText);
    $yards = getKickoffDistance($rawText);

    $outText .= "$yards yd KICKOFF by $kicker";

    break;//END OF KICKOFF*************************
  case "FUMBLE":
    break;//END OF FUMBLE*****************************
  case "UNDRAWABLE":
    $outText = "";
    break;//END OF UNDRAWABLE*****************************
  case "OTHER":
    if(preg_match('/(penalty)i/',$rawText)){
      $outText .= "PENALTY";
    }
    else{
      $outText = "";
    }
    break;//END OF OTHER*****************************
  default:
}

/*
foreach($vp->info as $key => $value) {
  $value = htmlspecialchars($value);
  ?><<?=$key?>><?=$value?><<?="/".$key?>>
<?}
*/

if($type!="OTHER" && $type!="UNDRAWABLE"){
  return stripDoubleSpaces($outText);
}
}
}

/*?>
</play>
<?*/

function toTitleCase($string){
return ucwords(strtolower($string));
}

function cleanEnd($string){
  while(preg_match('/[^0-9]/',$string)){
    $string = substr($string,0,(strlen($string)-1));
  }
  return $string;
}

function getColonName($string){
  $start = strpos($string,":");
  $endLastName = strpos($string,",");
  $lastName = trim(substr($string, ($start+1), ($endLastName - $start - 1)));
  
  $endFirstName = strpos($string, " ", ($endLastName + 2));
  $firstName = trim(substr($string, ($endLastName+1), ($endFirstName-$endLastName)));

  $name = toTitleCase($firstName . " " . $lastName);
  return $name;
}

function getInterceptorName($string){
  $start = strpos($string,"intercepted by ");
  $nameString = substr($string,$start);
  
  $endLastName = strpos($nameString,",");
  $lastName = substr($nameString,15,($endLastName-15));
  
  $endFirstName = strpos($nameString, " ", ($endLastName + 2));
  $firstName = trim(substr($nameString, ($endLastName+1), ($endFirstName-$endLastName)));

  $name = toTitleCase($firstName . " " . $lastName);
  return $name;
}

function getEndName($string){
  $start = strrpos($string,"(");
  $nameString = substr($string,$start);
//echo $nameString."<br/>"; 
  $endLastName = strpos($nameString,",");
  $lastName = trim(substr($nameString,1, ($endLastName-1)));

  $endFirstName = strpos($nameString,";");
  $firstName = trim(substr($nameString, ($endLastName+1),($endFirstName-$endLastName)-1));
 // echo $firstName;
  
  $name = toTitleCase($firstName . " " . $lastName);
  return $name;
}

function findTacklers($string){
  if(preg_match('/dropped pass/',$string)){
    return false;
  }
  if(preg_match('/downed/',$string)){
    return false;
  }
  
  $pattern = "/to the [A-Z]{3}[\d]{1,2,3} \(([A-Za-z]+,[A-Za-z]+(;))+\)/"; 
  //Find "To the [three letter, uppercase acronym][1,2,or 3 digit number] (Lname,Fname;Lname2,Fname2;[etc...])"
  if(preg_match('/to the [A-Z]{3}[\d]{1,3} \(([\w]+,(\ )[\w]+(;))+/',$string)){
    //echo "found it!";
  }

}

function getAttemptDistance($string){
  $start = strpos($string,"attempt from ");
  $distance = trim(cleanEnd(substr($string,($start+13),3)));
  return $distance;
}

function getWideDirection($string){
  $start = strpos($string,"wide");
  $direction = substr($string,($start+4));
  $directionEnd = strpos($direction,",");
  $direction = trim(strtolower(substr($direction,0,($directionEnd))));

  return $direction;
}

function getFairCatcher($string){
  $start = strpos($string,"fair catch by ") + 14;
  $nameString = substr($string,$start);
  
  $endLastName = strpos($nameString,",");
  $lastName = trim(substr($nameString,$start,($endFirstName-$start)));
  
  $endFirstName = strpos($nameString,".");
  $firstName = trim(substr($nameString, ($endLastName+2), ($endFirstName-$endLastName)));

  $name = toTitleCase($firstName . " " . $lastName);
  return $name;
}

function getCompletedTo($string){
  $completeTo = strpos($string,"complete to ");
  $nameString = substr($string,$completeTo+12);

  $endLastName = strpos($nameString,",");
  $lastName = trim(substr($nameString,0,$endLastName));

  $endFirstName = strpos($nameString," ",$endLastName+2);
  $firstName = trim(substr($nameString,$endLastName+1,$endFirstName-$endLastName - 1));
  
  $name = toTitleCase($firstName . " " . $lastName);
  return $name;
}

function getPassAttemptTo($string){
  $start = strpos($string,"pass attempt to ") + 16;
  $nameString = substr($string,$start);

  $endLastName = strpos($nameString,",");
  $lastName = trim(substr($nameString,0,$endLastName));

  $endFirstName = strpos($nameString," ",$endLastName+2);
  $firstName = trim(substr($nameString,$endLastName+1,$endFirstName-$endLastName - 1));

  $name = toTitleCase($firstName . " " . $lastName);
  return $name;
}

function getKickoffDistance($string){
  $start = strpos($string,"kickoff")+8;
  $end = strpos($string," ",$start);

  $distance = trim(substr($string,$start,$end-$start));
  return $distance;
}

function getReturner($string){
  $start = strpos($string,",");
}

function stripDoubleSpaces($string){
  return preg_replace('/( ){2,}/'," ",$string);
}
?>
