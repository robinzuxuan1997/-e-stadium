<?
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_user"));

//////////////////////////////////////////////////////
// Create Page object
//////////////////////////////////////////////////////

// NOTE: the Page object is re-created later on if we switch from
// public mode to admin mode
$p = new Page("mobile", "public", "page_login");

//////////////////////////////////////////////////////
// Extraneous Setup
//////////////////////////////////////////////////////

/////////////////////////////////////////////////////
// Register Form variables
/////////////////////////////////////////////////////
$p->register("username", "textbox", array("box_size" => "20"));
$p->register("password", "password", array("box_size" => "20"));
$p->register("login", "submit", array("value" => "Login"));
$p->register("logout", "hidden", array());

////////////////////////////////////////////////////
// Determine state based on view
////////////////////////////////////////////////////

if (Session::isLoggedIn()) {
  if ($logout == "1") $state = "process_logout";
  else                $state = "show_index";
} else {
  switch($view) {
    case "login_index": if ($p->submitIsSet("login")) $state = "process_login"; break;
    default: $state = "show_login_index";
  }
}

///////////////////////////////////////////////////
// Perform actions based on state
///////////////////////////////////////////////////

if ($state == "process_logout") {
  Session::logout();
  $msg = "You have logged out.";
  $view = "login_index";
}
elseif ($state == "show_index") {
  $view = "index";
}
elseif ($state == "process_login") {
  if (Session::authenticate($username, $password)) {
    $view = "concession_index";
  } else {
    $view = "login_index";
    $msg = "Username or password invalid";
  }
}
elseif ($state == "show_login_index") {
  $view = "login_index";
}
else {
  $view = "undefined";
}

/////////////////////////////////////////////////////
// Setup template variables
/////////////////////////////////////////////////////
if ($view == "index") {
  $u = new User(Session::userid());
  $name = $u->getFirstname() . " " . $u->getLastname();
  $p = new Page("mobile", "registered", "page_login");
  $view = "index";
}

///////////////////////////////////////////////////
// Include templates based on view
///////////////////////////////////////////////////
switch($view) {
  case "concession_index": include($path->getFilePath("page_concessions")); break;
  case "login_index": include($path->getFilePath("template_login_form")); break;
  default: include($path->getFilePath("template_undefined"));
}


