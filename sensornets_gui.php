<p>
  <h2>SensorNETS GUI:</h2>
  <form action="/sensornets_gui.php" method="POST">
    ID:
    <input type="text" name="ID">
    <br>
    Start Time:
    <input type="text" name="StartTime">
    <br>
    End Time:
    <input type="text" name="EndTime">
    <br>
    Sampling Rate:
    <input type="text" name="SamplingRate">
    <br>
    Game ID:
    <input type="text" name="GameID">
    <br>
    Category:
    <input type="text" name="Category">
    <br>
    Comments:
    <input type="text" name="Comments">
    <br><br>
    <input type="submit" name='submit'>
    <input type="submit" name='delete'>
    <input type="submit" name='update'>
  </form>
</p>

<?php
function open_db() {
    if(!($dbpipe = mysqli_connect("localhost","estad","V!p_f09","estadium"))){
        echo "Failed to connect to the database";
    }
    return($dbpipe);
}

$dbpipe = open_db();

if(isset($_POST['submit'])) {
	$id = $_POST['ID'];
	$starttime = $_POST['StartTime'];
	$endtime = $_POST['EndTime'];
	$samplingrate = $_POST['SamplingRate'];
	$gameid = $_POST['GameID'];
	$category= $_POST['Category'];
	$comments = $_POST['Comments'];

	if($id == "" || $startime == "" || $endtime == "" || $samplingrate = "" || $gameid == "" || $category == "" || $comments == "") {
        echo "Please fill out all fields.";
    } else {
    	$sql = "INSERT INTO table ('ID', 'StartTime', 'EndTime', 'SamplingRate', 'GameID', 'Category', 'Comments') VALUES ({$id}, {$starttime}, {$endtime}, {$samplingrate}, {$gameid}, {$category}, {$comments})";
    	mysqli_query($dbpipe,$sql);
    }
}elseif(isset($_POST['submit'])) {
    $id = $_POST['ID'];
    if($id == "" ) {
        echo "Please fill out id.";
    } else {
        $sql = "DELETE table ('ID', 'StartTime', 'EndTime', 'SamplingRate', 'GameID', 'Category', 'Comments') VALUES ({$id}, {$starttime}, {$endtime}, {$samplingrate}, {$gameid}, {$category}, {$comments})";
        mysqli_query($dbpipe,$sql);
    }
    }else{
    $id = $_POST['ID'];
    $starttime = $_POST['StartTime'];
    $endtime = $_POST['EndTime'];
    $samplingrate = $_POST['SamplingRate'];
    $gameid = $_POST['GameID'];
    $category= $_POST['Category'];
    $comments = $_POST['Comments'];

    if($id == "" || $startime == "" || $endtime == "" || $samplingrate = "" || $gameid == "" || $category == "" || $comments == "") {
        echo "Please fill out all fields.";
    } else {
        $sql = "UPDATE table ('ID', 'StartTime', 'EndTime', 'SamplingRate', 'GameID', 'Category', 'Comments') VALUES ({$id}, {$starttime}, {$endtime}, {$samplingrate}, {$gameid}, {$category}, {$comments})";
        mysqli_query($dbpipe,$sql);
    }
}
