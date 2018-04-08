<?
include_once(realpath(dirname(__FILE__) . "/../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("Main", "Public", "page_under_construction");
$p->startTemplate();
?>
<h3>Under Construction</h3>

This page is currently under construction.  Please check back later.<br>

<img src="<?=$path->getPath("image_under_construction")?>">
<?
$p->close();
?>
