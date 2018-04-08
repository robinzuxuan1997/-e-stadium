<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_food_location"));
include_once($path->getFilePath("class_food_item"));
include_once($path->getFilePath("class_food_stand"));
include_once($path->getFilePath("class_establishment"));
include_once($path->getFilePath("class_establishment_classification"));

$p = new Page("mobile", "public", "page_findit");
$p->register("findtype", "hidden");
$p->register("foodlocationid", "select",
             array("obj_type" => "FoodLocation",
                   "setget" => "ID",
                   "error_message" => "Location",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("FoodLocation", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findFoodLocationsOrdered", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getLocation")))); // and associated get functions



$p->register("fooditemid", "select",
             array("obj_type" => "FoodItem",
                   "setget" => "ID",
                   "error_message" => "Food Item",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("FoodItem", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findFoodItemsOrdered", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getFood")))); // and associated get functions

$p->register("foodstandid", "select",
             array("obj_type" => "FoodStand",
                   "setget" => "ID",
                   "error_message" => "Food Stand",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("FoodStand", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findFoodStandsOrdered", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getStand")))); // and associated get functions

$p->register("submit_foodlocation", "submit", array("value" => "Find"));
$p->register("submit_fooditem", "submit", array("value" => "Find"));
$p->register("submit_foodstand", "submit", array("value" => "Find"));

$p->register("hotelid", "select",
             array("obj_type" => "Establishment",
                   "setget" => "id",
                   "error_message" => "Hotel Name",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("Establishment", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findHotelsOrdered", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getName")))); // and associated get functions
$p->register("hotelcityid", "select",
             array("obj_type" => "Establishment",
                   "setget" => "none",
                   "error_message" => "City",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("Establishment", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findHotelCities", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getCity")))); // and associated get functions
$p->register("hoteldistanceid", "select",
             array("obj_type" => "Location",
                   "setget" => "id",
                   "error_message" => "Distance",
                   "get_choices_array_func" => "getDistanceChoices"));

$p->register("submit_hotelname", "submit", array("value" => "Find"));
$p->register("submit_hotelcity", "submit", array("value" => "Find"));
$p->register("submit_hoteldist", "submit", array("value" => "Find"));

$p->register("restaurantid", "select",
             array("obj_type" => "Establishment",
                   "setget" => "id",
                   "error_message" => "Restaurant Name",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("Establishment", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findRestaurantsOrdered", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getName")))); // and associated get functions
$p->register("restaurant_classificationid", "select",
             array("obj_type" => "EstablishmentClassification",
                   "setget" => "id",
                   "error_message" => "Food Type",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("EstablishmentClassification", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findRestaurantClassificationsOrdered", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getName")))); // and associated get functions
$p->register("restaurant_cityid", "select",
             array("obj_type" => "Establishment",
                   "setget" => "none",
                   "error_message" => "City",
                   "get_choices_array_func" => "getIdChoices",
                   "get_choices_array_func_args" => array("Establishment", // name of object to call find* function on
                                                          false, // ID number to pass to constructor of that object
                                                          "findRestaurantCitiesOrdered", // name of find function
                                                          false, // Optional array of arguments to find function
                                                          array("value" => "getID",  // Format of returned choices array,
                                                                "text" => "getCity")))); // and associated get functions
$p->register("restaurant_distanceid", "select",
             array("obj_type" => "Location",
                   "setget" => "id",
                   "error_message" => "Distance",
                   "get_choices_array_func" => "getDistanceChoices"));

$p->register("submit_restaurantname", "submit", array("value" => "Find"));
$p->register("submit_restaurantclassification", "submit", array("value" => "Find"));
$p->register("submit_restaurantcity", "submit", array("value" => "Find"));
$p->register("submit_restaurantdist", "submit", array("value" => "Find"));

$p->register("serviceid", "select",
             array("setget" => "none",
                   "error_message" => "Service Type",
                   "get_choices_array_func" => "getServicesChoices"));

$p->register("submit_service", "submit", array("value" => "Find"));


/////////////////////////////////////////////////
// Decide Operational State Based on Last View //
/////////////////////////////////////////////////

switch($view) {
  case "index": if ($findtype == "food")     $state = "show_food_index";
           else if ($findtype == "hotel")    $state = "show_hotel_index";
           else if ($findtype == "rest")     $state = "show_rest_index";
           else if ($findtype == "services") $state = "show_services_index";
           else                              $state = "undefined";
    break;
  case "food_index": if ($p->submitIsSet("submit_foodlocation")) $state = "process_foodlocation";
                else if ($p->submitIsSet("submit_fooditem"))     $state = "process_fooditem";
                else if ($p->submitIsSet("submit_foodstand"))    $state = "process_foodstand";
                else                                             $state = "undefined";
    break;
  case "rest_index": if ($p->submitIsSet("submit_restaurantname"))           $state = "process_restname";
                else if ($p->submitIsSet("submit_restaurantclassification")) $state = "process_restclass";
                else if ($p->submitIsSet("submit_restaurantcity"))           $state = "process_restcity";
                else if ($p->submitIsSet("submit_restaurantdist"))           $state = "process_restdist";
                else                                                         $state = "undefined";
    break;
  case "hotel_index": if ($p->submitIsSet("submit_hotelname")) $state = "process_hotelname";
                 else if ($p->submitIsSet("submit_hotelcity")) $state = "process_hotelcity";
                 else if ($p->submitIsSet("submit_hoteldist")) $state = "process_hoteldist";
                 else                                          $state = "undefined";
    break;
  case "service_index": if ($p->submitIsSet("submit_service")) $state = "process_service";
                        else                                   $state = "undefined";
    break;
  case "rest_list": $state = "process_restname";
    break;
  case "hotel_list": $state = "process_hotelname";
    break;
  default: $state = "show_index";
}

if ($state == "show_index") {
  $view = "index";
}
else if ($state == "show_food_index") {
  $view = "food_index";
}
else if ($state == "show_hotel_index") {
  $view = "hotel_index";
}
else if ($state == "show_rest_index") {
  $view = "rest_index";
}
else if ($state == "show_services_index") {
  $view = "service_index";
}
else if ($state == "process_foodlocation") {
  $e = new FoodLocation($foodlocationid);
  $es = $e->findFoodLocationsNearby();
  $near_stands = array();
  while ($loc = $es->getOne()) {
    $stands = $loc->findFoodStandsAtLocation();
    while ($stand = $stands->getOne()) {
      array_push($near_stands, array("stand_name" => $stand->getStand(),
                                     "stand_section" => $loc->getLocation()));
    }
  }
  $view = "food_location";
}
else if ($state == "process_fooditem") {
  $f = new FoodItem($fooditemid);
  $found_stands = $f->findStandsWithItem();
  $stands = array();
  while ($stand = $found_stands->getOne()) {
    $locs = $stand->findFoodLocationsWithStand();
    while ($loc = $locs->getOne()) {
      array_push($stands, array("name" => $stand->getStand(),
                                "section" => $loc->getLocation()));
    }
  }
  $food_item_text = $f->getFood();
  $view = "food_item";
}
else if ($state == "process_foodstand") {
  $f = new FoodStand($foodstandid);
  $locs = $f->findFoodLocationsWithStand();
  $locations = array();
  while ($loc = $locs->getOne()) {
    array_push($locations, array("section" => $loc->getLocation()));
  }
  $items = $f->findFoodItemsAtStand();
  $food_items = array();
  while ($food = $items->getOne()) {
    array_push($food_items, array("food" => $food->getFood()));
  }
  $food_stand_text = $f->getStand();
  $view = "food_stand";
}
else if ($state == "process_restname") {
  $establishment = new Establishment($restaurantid);
  $view = "rest_display";
}
else if ($state == "process_restclass") {
  $e = new Establishment();
  $establishments = $e->findRestaurantsByClassificationid($restaurant_classificationid);
  $ec = new EstablishmentClassification($restaurant_classificationid);
  $search_text = $ec->getName();
  $view = "rest_list";
}
else if ($state == "process_restcity") {
  $e = new Establishment($restaurant_cityid);
  $establishments = $e->findRestaurantsByCity($e->getCity());
  $search_text = $e->getCity();
  $view = "rest_list";
}
else if ($state == "process_restdist") {
  list($min, $max) = split("-", $restaurant_distanceid);
  if ($max == "inf") $max = "9999";
  $e = new Establishment();
  $establishments = $e->findRestaurantsByDist($min, $max);
  $ch = Choices::getDistanceChoices();
  foreach($ch as $choice) {
    if ($choice[value] == $restaurant_distanceid) {
      $search_text = $choice[text];
    }
  }
  $view = "rest_list";
}
else if ($state == "process_hotelname") {
  $establishment = new Establishment($hotelid);
  $view = "hotel_display";
}
else if ($state == "process_hotelcity") {
  $e = new Establishment($hotelcityid);
  $establishments = $e->findHotelsByCity($e->getCity());
  $search_text = $e->getCity();
  $view = "hotel_list";
}
else if ($state == "process_hoteldist") {
  list($min, $max) = split("-", $hoteldistanceid);
  if ($max == "inf") $max = "9999";
  $e = new Establishment();
  $establishments = $e->findHotelsByDist($min, $max);
  $ch = Choices::getDistanceChoices();
  foreach($ch as $choice) {
    if ($choice[value] == $hoteldistanceid) {
      $search_text = $choice[text];
    }
  }
  $view = "hotel_list";
}
else if ($state == "process_service") {
  if ($serviceid == "1") { // First Aid
    $service_message = "The first aid is located outside section 111 and 119.";
    $service_image = $path->getPath("image_stadium_firstaid");
  } elseif ($serviceid == "2") { // Lost and Found
    $service_message = "The lost and found is located outside section 117.";
    $service_image = $path->getPath("image_stadium_lostfound");
  } elseif ($serviceid == "3") { // Disability Accomodations
    $service_message = "Disability Accommodation is located in section 118 and 119.";
    $service_image = $path->getPath("image_stadium_disability");
  }
  $view = "service_index";
}
else {
  $view = "undefined";
}


//////////////////////////////
// Setup Template Variables //
//////////////////////////////

$p->getChoices();
if ($view == "index") {
  $findtype_choices = array(array("value" => "food", "text" => "Find Concessions"),
                            array("value" => "hotel", "text" => "Find Hotels"),
                            array("value" => "rest", "text" => "Find Restaurants"),
                            array("value" => "services", "text" => "Find Services"));
}
else if ($view == "rest_display" || $view == "hotel_display") {
  $logo = $establishment->getLogo();
  $name = $establishment->getName();
  $address = $establishment->getAddress();
  $city = $establishment->getCity();
  $ustate = $establishment->getState();
  $zipcode = $establishment->getZipcode();
  $phone = $establishment->getPhone();
  $website = $establishment->getUrl();
  $price = $establishment->getPrice();
  if ($price == "none" || !$price) $price = "No price guideline";
  $distance = $establishment->getDistance();
}
else if ($view == "rest_list" || $view == "hotel_list") {
  $establishment_list = array();
  while ($e = $establishments->getOne()) {
    array_push($establishment_list, array("name" => $e->getName(),
                                          "address" => $e->getAddress(),
                                          "id" => $e->getID()));
  }
  if ($view == "rest_list") { 
    $title_text = "Find Restaurants";
    $idvarname = "restaurantid";
  }
  else {
    $title_text = "Find Hotels";
    $idvarname = "hotelid";
  }
}


/////////////////////////////////////////
// Include Template File based on view //
/////////////////////////////////////////

switch($view) {
          case "index": include_once($path->getFilePath("template_findit_index"));         break;
     case "food_index": include_once($path->getFilePath("template_findit_food_index"));    break;
  case "food_location": include_once($path->getFilePath("template_findit_food_location")); break;
      case "food_item": include_once($path->getFilePath("template_findit_food_item"));     break;
     case "food_stand": include_once($path->getFilePath("template_findit_food_stand"));    break;
    case "hotel_index": include_once($path->getFilePath("template_findit_hotel_index"));   break;
     case "hotel_list": include_once($path->getFilePath("template_findit_hotel_list"));    break;
  case "hotel_display": include_once($path->getFilePath("template_findit_hotel_display")); break;
     case "rest_index": include_once($path->getFilePath("template_findit_rest_index"));    break;
      case "rest_list": include_once($path->getFilePath("template_findit_rest_list"));     break;
   case "rest_display": include_once($path->getFilePath("template_findit_rest_display"));  break;
  case "service_index": include_once($path->getFilePath("template_findit_service_index")); break;
  default: include_once($path->getFilePath("template_undefined"));
}

