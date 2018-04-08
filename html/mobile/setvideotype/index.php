<?
// Note: this page requires the "001" set of videos to be in Database/Videos/browservids/

include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_game"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_video"));
include_once($path->getFilePath("class_browser"));
include_once($path->getFilePath("class_scripts_global_settings"));

GlobalSettings::load("site_links", true); // gets trans_dirs and transcode_extensions

$p = new Page("mobile", "public", "page_setvideotype");

$p->register("medium", "hidden", array());
$p->register("encoding", "hidden", array());
$p->register("setvideotype", "hidden", array());

if ($setvideotype == "1") {
  $b = new Browser();
  $b->setSessionAutodetect(serialize($_SESSION));
  Session::setVideoType($medium, $encoding);
  $b->setUserAgent($_SERVER[HTTP_USER_AGENT]);
  $b->setSessionUserdefined(serialize($_SESSION));
  $b->save(true);
  $msg = "Video type set successfully.  All video links that you see on our site will now be the new type that you have chosen until you close your browser.";
}

$vidpath = "Sample";
$filename = "Sample";
  
$choices = array();                                                                                  
foreach(array("rtsp",
		 "http") as $medium) {                                                          
  foreach($trans_dirs as $trans) {                                                                   
    // get rid of special cases: cannot stream any wmv or pc_mp4                                     
  if ($medium == "rtsp") {
    if (preg_match("/wmv/", $trans) || preg_match("/pc_mp4/", $trans)) continue;                   
    } 
    switch($medium) {
     case "rtsp": $text = "Stream"; break;
      case "http": $text = "Download"; break;                                                        
    }
    $enc_parts = split("_", GlobalSettings::noTrailingSlash($trans));                                
    $enc_parts[0][0] = strtoupper($enc_parts[0][0]);                                                 
    if ($enc_parts[0] == "Pc") $enc_parts[0] = "PC";                                                 
    $enc_parts[1] = strtoupper($enc_parts[1]);
    $text .= ", $enc_parts[0] $enc_parts[1]"; 

    array_push($choices, array("medium" => $medium,                                                  
                               "encoding" => $trans, 
                               "text" => $text,
                               "link" => Check::constructVideoLink($vidpath, $filename, $medium, $trans)));                          
  
}                                     
}
include_once($path->getFilePath("template_setvideotype_index"));
?>
