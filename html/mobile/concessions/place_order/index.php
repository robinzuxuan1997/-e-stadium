<?
include_once(realpath(dirname(__FILE__) . "/../../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_session"));
include_once($path->getFilePath("class_user"));
include_once($path->getFilePath("class_orders_users"));
include_once($path->getFilePath("class_food"));
include_once($path->getFilePath("class_stand"));
include_once($path->getFilePath("class_stands_food"));
include_once($path->getFilePath("class_order"));
include_once($path->getFilePath("class_orders_food"));

//////////////////////////////////////////////////////
// Create Page object
//////////////////////////////////////////////////////

$p = new Page("mobile", "registered", "page_concessions_index");

//////////////////////////////////////////////////////
// Extraneous Setup
//////////////////////////////////////////////////////

$usual = $_REQUEST[usual];
$userid = $_SESSION[userid];

/////////////////////////////////////////////////////
// Register Form variables
/////////////////////////////////////////////////////
$p->register("place","submit",
             array("setget"=> "none",
                   "value" => "Place Order"));
$p->register("choose_food","submit",
             array("setget"=> "none",
                   "value" => "Next"));
$p->register("choose_drink","submit",
             array("setget"=>"none",
                   "value" => "Place Order"));
$p->register("orderid","hidden",
             array("setget"=>"Orderid"));
$p->register("num","hidden",
             array("setget"=>"none"));
if($view =="food")
for($i=1;$i<=$num;$i++) {
  $var = "food_".$i;
  $$var = $_REQUEST["$var"];
  $_SESSION[$var] = $$var;
}
elseif($view == "drink")
for($i=1;$i<=$num;$i++) {
  $var = "drink_".$i;
  $$var = $_REQUEST["$var"];
  $_SESSION[$var] = $$var;
}
//////////////////////////////////////////////////
// Decide state based on view
//////////////////////////////////////////////////

  if($usual == 1)       $state = "the_usual";
  else {
    switch ($view) {
      case "confirm": if($p->submitIsSet("place")) $state = "process_order";
                    else                         $state = "process_order";
       break;
      case "food": if($p->submitIsSet("choose_food")) $state = "show_drink";
                    else                         $state = "undefined";
       break;
      case "drink": if($p->submitisSet("choose_drink")) $state = "confirm";
                    else                         $state = "undefined";
       break;
      default: $state = "place_order";
    }
  }
  $u = new User($userid);
  $standid = $u->findLocation();
  if(Check::isInt($standid)) {
    $s = new Stand();
    $stand_name = $s->findNameByStandid($standid);
  }else{
  //if no default location, go to choose_location
    $state = "show_choose_location";
  }
 
///////////////////////////////////////////////////
// Perform actions based on state
///////////////////////////////////////////////////
if($state == "place_order") {
  $view = "food";
}
elseif($state =="confirm") {
  $view = "confirm";
}
elseif($state =="show_drink") {
  $view = "drink";
}

elseif($state == "process_order"){
  $sf = new Stands_Food();
  $o = new Order();
  $o->save();
  $orderid = $o->getOrderid();
  $ou = new Orders_Users();
  $ou->setOrderid($o->getOrderid());
  $ou->setUserid($userid);
  $ou->save();
  $i=0;
  $foodids = $sf->findFoodItemsByStandid($standid);
  $foods = array();
  foreach($foodids as $f){
    array_push($foods, array("name"=>$f->getName(),
                             "category"=>$f->getCategory(),
                             "id"=>$f->getFoodid(),
                             "cost"=>$f->getCost()));
  }
  $items=0;
  foreach($foods as $f) {
    $of = new Orders_Food();
    $of->setOrderid($orderid);
    if($f[category] =="FOOD") {
      $i++;
      $var = "food_".$i;
      $quan =  $_SESSION[$var];
      if($quan > 0){ 
        $items = $items + $quan;
        $of->setQuantity($quan);
        $of->setFoodid($f[id]);
        $of->save();
      }
    }elseif($f[category] =="DRINK") {
      $j++;
      $var = "drink_".$j;
      $quan = $_SESSION[$var];
      if($quan>0) {
        $items = $items + $quan;
        $of->setQuantity($quan);
        $of->setFoodid($d[id]);
        $of->save();
      }
    }
  }
  $o->setTimeOrdered(date('H:i'));
  $minutes = $items * 5;
  $time = array();
  $time[hour] = date('H');
  $time[min] = date('i') + $minutes;
  while($time[min] >= 60) {
    $time[min] -= 60;
    $time[hour] += 1;
  }
  $time_string = $time[hour] .":".$time[min];
  $o->setEstTime( $time_string); 
  $o->save();
  $view = "thanks_time";
}
elseif($state == "the_usual") {
  $view = "usual";
}
elseif($state == "show_choose_location"){
  $view = "choose_location";
}
else {
  $view = "undefined";
}

/////////////////////////////////////////////////////
// Setup template variables
/////////////////////////////////////////////////////
if ($view == "food" ) {
  //query food items for default location
  $sf = new Stands_Food();
  $foodids = $sf->findFoodItemsByStandid($standid);
  $foods = array();
  foreach($foodids as $f){
    array_push($foods, array("name"=>$f->getName(),
                             "category"=>$f->getCategory(),
                             "cost"=>$f->getCost()));
  }

}elseif ( $view == "drink") {
  //query food items for default location
  $sf = new Stands_Food();
  $foodids = $sf->findFoodItemsByStandid($standid);
  $drinks = array();
  foreach($foodids as $f){
    array_push($drinks, array("name"=>$f->getName(),
                             "category"=>$f->getCategory(),
                             "cost"=>$f->getCost()));
  }
}elseif ($view == "confirm" or $view == "usual") {
  //query food items for default location
  $sf = new Stands_Food();
  $foodids = $sf->findFoodItemsByStandid($standid);
  $foods = array();
  foreach($foodids as $f){
    array_push($foods, array("name"=>$f->getName(),
                             "category"=>$f->getCategory(),
                             "cost"=>$f->getCost()));
  }
  $i = 1;
  $j = 1;
  $food = array();
  $drink = array();
  foreach ($foods as $f) {
    if($f[category] == "FOOD"){
      $quantity_var = "food_".$i;
      $quan = $_SESSION[$quantity_var];
      array_push($food, array("name"=>$f[name],
                              "category"=>$f[category],
                              "cost"=>$f[cost],
                              "quantity"=>$quan));
      $i++;
    }
    else{
      $quantity_var = "drink_".$j;
      array_push($drink, array("name"=>$f[name],
                              "category"=>$f[category],
                              "cost"=>$f[cost],
                              "quantity"=>$$quantity_var));
      $j++;
    }
  }
  
}elseif($view == "thanks_time"){
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

}



///////////////////////////////////////////////////
// Include templates based on view
///////////////////////////////////////////////////

switch($view) {
  case "food": include($path->getFilePath("template_concessions_place_food"));
    break;
  case "drink": include($path->getFilePath("template_concessions_place_drink"));
    break;
  case "confirm":
  case "usual": include($path->getFilePath("template_concessions_place_confirm"));
    break;
  case "choose_location": include($path->getFilePath("page_concessions_choose_location"));
    break;
  case "thanks_time": include($path->getFilePath("template_concessions_place_thanks"));
    break;
  default: include($path->getFilePath("template_undefined"));
}


