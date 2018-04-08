<html>
<h1>THIS IS A TEST PAGE </h1>
<?
try{
include_once("/var/www/html/friendfinder/db/dbAccess.php");
}
catch(Exception $e){
 echo "<h3>";
 echo "error!!!!!!!!!!1";
// echo($e->getMessage());
 echo "</h3>";
}
echo "<h2> this is from a php block </h2>";
$ret = DB::testQuery();
while($row = mysqli_fetch_array($ret))
  {
  echo $row['Username'];
  echo "<br>";
  }
/*
    echo('<h2>')
    try{
    if(isset(DB::$testMessage)){
    echo(DB::$testMessage);
    }
    else{
    echo('Static variable didnt work :(');
    }
    }
    catch(Exception $e){
    echo($e->getMessage());
    }
    echo('</h2>');
*/
?>
</html>
