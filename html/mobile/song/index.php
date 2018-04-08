<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_team"));

$p = new Page("mobile", "public", "page_mobile_song");

$p->startTemplate();
?>
<center><font class="mobile_h1"><u>Hail Purdue</u><br><br></font></center>
<b>First Verse:</b>
<br>
To Your Call Once More We Rally;<br>
Alma Mater Hear Our Praise.<br>
Where The Wabash Spreads Its Valley;<br>
Filled With Joy Our Voices Raise.<br>
From The Skies In Swelling Echoes<br>
Come The Cheers That Tell The Tale<br>
Of Your Vict'ries And Your Heros,<br>
Hail Purdue! We Sing All Hail!<br>

<hr>
<b>Chorus:</b>
<br>
Hail, Hail To Old Purdue!<br>
All Hail To Our Old Gold And Black!<br>
Hail, Hail To Old Purdue!<br>
Our Friendship May She Never Lack.<br>
Ever Grateful, Ever True,<br>
Thus We Raise Our Song Anew;<br>
Of The Days We've Spent With You,<br>
All Hail Our Own Purdue!<br>

<hr>
<b>Second Verse:</b>
<br>
When In After Years We're Turning,<br>
Alma Mater, Back To You.<br>
May Our Hearts With Love Be Yearning<br>
For The Scenes Of Old Purdue.<br>
Back Among Your Pathways Winding<br>
Let Us Seek What Lies Before;<br>
Fondest Hopes And Aims E'er Finding,<br>
While We Sing Of Days Of Yore.<br>

<?
$p->close();
?>
