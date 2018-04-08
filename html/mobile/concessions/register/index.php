<?
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_user"));

//////////////////////////////////////////////////////
// Create Page object
//////////////////////////////////////////////////////

$p = new Page("mobile", "public", "page_register");

//////////////////////////////////////////////////////
// Extraneous Setup
//////////////////////////////////////////////////////

/////////////////////////////////////////////////////
// Register Form variables
/////////////////////////////////////////////////////
$p->register("username", "textbox", array("box_size" => "20"));
$p->register("password1", "password", array("box_size" => "20"));
$p->register("password2","password",array("box_size"=>"20"));
$p->register("firstname","textbox",array("box_size"=>"20"));
$p->register("lastname","textbox",array("box_size"=>"20"));
$p->register("email","textbox",array("box_size"=>"20"));
$p->register("register","submit",array("value"=>"Register"));

////////////////////////////////////////////////////
// Determine state based on view
////////////////////////////////////////////////////

  switch($view) {
    case "form": if ($p->submitIsSet("register")) $state = "process_registration"; break;
    default: $state = "show_register_form";
  }

///////////////////////////////////////////////////
// Perform actions based on state
///////////////////////////////////////////////////

if ($state == "process_registration") {
  $p->checkVars();
  if ($msg = Check::validPassword($password1, $password2)) {
    $p->registerErr("password1", "Password" . $msg);
    $p->registerErr("password2", "");
  }

  if ($p->noErrors()) {
    $u = new User($userid);
    if ($password1) $u->setPassword(md5($password1));
    $u->setUsername($username);
    $u->setFirstname($firstname);
    $u->setLastname($lastname);
    $u->setEmail($email);
    $u->setActive("ACTIVE");
    $u->save();
    $p->getVars($u);
    $view = "success";
  } else {
    echo "errors";
    $view = "error";
  }
}
elseif ($state == "show_register_form") {
  $view = "form";
}
else {
  $view = "undefined";
}

/////////////////////////////////////////////////////
// Setup template variables
/////////////////////////////////////////////////////
if ($view == "form") {
  $u = new User(Session::userid());

}


///////////////////////////////////////////////////
// Include templates based on view
///////////////////////////////////////////////////
switch($view) {
  case "error": 
  case "form": include($path->getFilePath("template_register_form")); break;
  case "success": include($path->getFilePath("template_register_success")); break; 
  default: include($path->getFilePath("template_undefined"));
}


