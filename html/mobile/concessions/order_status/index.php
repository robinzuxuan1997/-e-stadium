<?
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_user"));
include_once($path->getFilePath("class_orders_users"));
include_once($path->getFilePath("class_order"));
include_once($path->getFilePath("class_orders_food"));
include_once($path->getFilePath("class_food"));

//////////////////////////////////////////////////////
// Create Page object
//////////////////////////////////////////////////////

// NOTE: the Page object is re-created later on if we switch from
// public mode to admin mode
$p = new Page("mobile", "registered", "page_concessions_index");

//////////////////////////////////////////////////////
// Extraneous Setup
//////////////////////////////////////////////////////
$userid = $_SESSION[userid];
/////////////////////////////////////////////////////
// Register Form variables
/////////////////////////////////////////////////////
$p->register("orderid",
             "hidden",
             array("getset"=>"Orderid"));
                   
////////////////////////////////////////////////////
// Determine state based on view
////////////////////////////////////////////////////
//query orderid by userid
$ou = new Orders_Users();
$orderid = $ou->findMaxOrderidByUserid($userid);

if(!Check::isInt($orderid)) {
  $view = "error";
}else{
   switch ($view) {
     default: $state = "show_status";
   }
}
///////////////////////////////////////////////////
// Perform actions based on state
///////////////////////////////////////////////////
if($state == "show_status") {
  $view = "index";
}

/////////////////////////////////////////////////////
// Setup template variables
/////////////////////////////////////////////////////
if($view == "index") {
  $of = new Orders_Food();
  $o = new Order($orderid);
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
  $orders = $of->findOrderByOrderid($orderid);
  $order = array();
  foreach ($orders as $ord) { 
    $foodid = $ord->getFoodid();
    $f = new Food($foodid);
    array_push($order, array("name" => $f->getName(),
                             "cost" => $f->getCost(),
                             "quantity" => $ord->getQuantity()));
  }
}
///////////////////////////////////////////////////
// Include templates based on view
///////////////////////////////////////////////////
switch($view) {
  case "index": include($path->getFilePath("template_concessions_status_index"));
    break;
  case "error": include($path->getFilePath("template_concessions_status_error"));
    break;
  default: include($path->getFilePath("template_undefined"));
}


