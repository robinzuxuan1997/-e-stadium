<?
include_once(realpath(dirname(__FILE__) . "/../include/Page/class_path.php"));
$path = new Path();
?>
<html><body bgcolor="#2F2F2F">
<center><img src="<?=$path->getPath("image_mobile_header_big")?>?junk=<?=uniqid("big_header_", 1)?>"></center>
</body></html>

