<?php 
echo "here";
 $source_file= 'ftp://fanslive:livestats@ftp.netitor.com/geot/m-footbl/geot.xml/*';
 $dest_file = 'http://estad:V!p_f09@vl465-udev.ece.gatech.edu/estadium/gt09/scripts/stats_import/m-footbl';
$upload =copy($source_file, $dest_file);
echo "Working!!!";
?>
