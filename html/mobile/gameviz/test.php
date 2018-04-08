<html><body>
<?php
$p = "1st & 10 at CMU49: Sheets,Kory rush for 18 yards to the CMU31, 1ST DOWN PUR, out-of-bounds (WEST, Chaz), PENALTY CMU face mask (WEST, Chaz) 15 yards to the CMU16, 1ST DOWN PUR.";

$arr = explode("PENALTY", $p, 2);
$sspot = $arr[1];
echo $sspot . "<br><br>";
$arr2 = explode("to the ", $p, 2);
$sspot = substr($arr2[1], 0, 5);
echo $sspot . "<br><br>";

if(substr_count($sspot, "PUR"))
  $sspot =(int)substr($arr2[1], 3, 2);
 else if(substr_count($sspot, "50"))
   $sspot = 50;
 else
   $sspot = 100-(int)substr($arr2[1], 3, 2);
echo $sspot . "<br><br>";

?>
</body></html>