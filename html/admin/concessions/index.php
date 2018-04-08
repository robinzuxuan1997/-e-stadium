<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_user"));
include_once($path->getFilePath("class_orders_users"));
include_once($path->getFilePath("class_order"));
include_once($path->getFilePath("class_orders_food"));
include_once($path->getFilePath("class_food"));
include_once($path->getFilePath("class_check"));

//////////////////////////////////////////////////////
// Create Page object
//////////////////////////////////////////////////////

// NOTE: the Page object is re-created later on if we switch from
// public mode to admin mode
$p = new Page("web", "registered", "page_concessions_index");

//////////////////////////////////////////////////////
// Extraneous Setup
//////////////////////////////////////////////////////

/////////////////////////////////////////////////////
// Register Form variables
/////////////////////////////////////////////////////
$done = $_REQUEST[done];
                   
////////////////////////////////////////////////////
// Determine state based on view
////////////////////////////////////////////////////
if(Check::isInt($done)) $state = "set_done";
else $state = "show_status";
/*
switch ($view) {
  case "index": if($done) $state = "set_done";
  break;
  default: $state = "show_status";
}
*/
///////////////////////////////////////////////////
// Perform actions based on state
///////////////////////////////////////////////////
if($state == "set_done") {
  $o = new Order($done);
  $o->setEstTime("DONE");
  $o->save();
}
$view = "index";

/////////////////////////////////////////////////////
// Setup template variables
/////////////////////////////////////////////////////
if($view == "index") {
  $o = new Order();
  $u = new User();
  $orders = $o->findActiveOrders();
  $all_orders = array();
  foreach ($orders as $o) { 
    $of = new Orders_Food();
    $ou = new Orders_Users();
    $userid = $ou->findUseridByOrderid($o->getOrderid());
    $foods = $of->findAllFoodByOrderid($o->getOrderid());
      $foodinfo = array();
    foreach($foods as $food) {
      $foodid = $food->getFoodid();
      $f = new Food($foodid);
      array_push($foodinfo, array("name" => $f->getName(),
                                  "cost" => $f->getCost(),
                                   "quantity" => $food->getQuantity()));
    }
    $start_time = date("H:i");
    $end_time = $o->getEstTime();

    $start = explode(":",$start_time);
    $s_hr = $start[0];
    $s_min = $start[1];

    $end = explode(":",$end_time);
    $e_hr = $end[0];
    $e_min = $end[1];
    $hr = $e_hr - $s_hr;
    if($hr == 1) {
      $min = $e_min + (60-$s_min);
    }
    else {
      $min = $e_min - $s_min;
    }

    array_push($all_orders,array("orderid" => $o->getOrderid(),
                            "order" => $foodinfo,
                            "username" => $u->findUsernameByUserid($userid),
                            "min" => $min));
  }
}
///////////////////////////////////////////////////
// Include templates based on view
///////////////////////////////////////////////////
switch($view) {
  case "index": include($path->getFilePath("template_admin_concessions_index"));
    break;
  case "error": include($path->getFilePath("template_admin_concessions_status_error"));
    break;
  default: include($path->getFilePath("template_undefined"));
}


