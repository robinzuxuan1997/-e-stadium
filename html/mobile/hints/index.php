<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));

$p = new Page("mobile", "public", "page_helpful_hints");

$p->startTemplate();

?>
<center><font class="mobile_h1"><u>Helpful Hints</u><br></font></center>
<ul>
  <li><a href="<?=$path->getPath("page_findit")?>">Find It!</a></li>
  <li><a href="<?=$path->getPath("page_rules_regulations")?>">Rules and Regulations</a></li>
</ul>
<?
$p->close();
?>
