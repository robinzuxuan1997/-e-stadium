<?
include_once(realpath(dirname(__FILE__) . "/../../../include/Page/class_path.php"));
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_check"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("class_roster"));

///////////////////////////////////////////////////
// Create Page object
///////////////////////////////////////////////////

$p = new Page("web", "admin", "page_admin_bios");

///////////////////////////////////////////////////
// Extraneous Setup
///////////////////////////////////////////////////



///////////////////////////////////////////////////
// Register Form Variables
///////////////////////////////////////////////////

// Submit Buttons
$p->register("edit_staff",   "submit", array("value" => "Edit/Add Staff"));
$p->register("edit_players", "submit", array("value" => "Edit/Add Players"));
$p->register("season_copy",  "submit", array("value" => "Mass Season to Season Copy"));
$p->register("save",         "submit", array("value" => "Save"));
$p->register("cancel",       "submit", array("value" => "Cancel"));
$p->register("delete",       "submit", array("value" => "Delete"));
$p->register("yes",          "submit", array("value" => "Yes"));
$p->register("copy",         "submit", array("value" => "Copy"));
$p->register("confirm",      "submit", array("value" => "Confirm"));

// Hidden variables
$p->register("add",        "hidden", array());
$p->register("stafflist",  "hidden", array());
$p->register("playerlist", "hidden", array());

// Player/Staff independent variables
$p->register("seasonid", "select", array("get_choices_array_func" => "getSeasonChoices",
                                         "setget" => "SeasonID",
                                         "error_message" => "Season"));
$p->register("teamid", "select", array("get_choices_array_func" => "getTeamChoices",
                                       "setget" => "TeamID",
                                       "error_message" => "Team"));
$p->register("copy_to_season", "select", array("get_choices_array_func" => "getSeasonChoices",
                                               "error_message" => "Copy to season",
                                               "obj_type" => "copy"));
// Player/Staff dependent variables
$p->register("staff_userid", "radio", array("get_choices_array_func" => "getStaffIDChoices",
                                            "get_choices_array_func_args" => array($teamid, $seasonid, "page_admin_bios")));
$p->register("player_userid", "radio", array("get_choices_array_func" => "getPlayerIDChoices",
                                             "get_choices_array_func_args" => array($teamid, $seasonid, "page_admin_bios")));

// Staff variables
$p->register("staff_fname", "textbox", array("box_size" => "30",
                                             "error_message" => "First name",
                                             "check_func" => "validShortText",
                                             "setget" => "Fname",
                                             "obj_type" => "staff"));
$p->register("staff_lname", "textbox", array("box_size" => "30",
                                             "error_message" => "Last name",
                                             "check_func" => "validShortText",
                                             "setget" => "Lname",
                                             "obj_type" => "staff"));
$p->register("staff_position", "select", array("error_message" => "Position",
                                               "get_choices_array_func" => "getPositionChoices",
                                               "get_choices_array_func_args" => array("staff"),
                                               "setget" => "Position",
                                               "obj_type" => "staff"));
$p->register("staff_bio", "textarea", array("error_message" => "Bio",
                                            "check_func" => "validLongText",
                                            "setget" => "Bio",
                                            "obj_type" => "staff"));
$p->register("staff_image", "file", array("filedir" => $path->getFilePath("image_coach_basedir"),
                                          "filedir_webpath" => $path->getPath("image_coach_basedir"),
                                          "setget" => "ImagePath",
                                          "error_message" => "Picture",
                                          "check_func" => "validPictureFile",
                                          "check_func_args" => array(true), // can have an empty picture file
                                          "obj_type" => "staff"));

// Player variables
$p->register("player_fname", "textbox", array("box_size" => "30",
                                              "error_message" => "First name",
                                              "check_func" => "validShortText",
                                              "setget" => "Fname",
                                              "obj_type" => "player"));
$p->register("player_lname", "textbox", array("box_size" => "30",
                                              "error_message" => "Last name",
                                              "check_func" => "validShortText",
                                              "setget" => "Lname",
                                              "obj_type" => "player"));
$p->register("player_number", "textbox", array("box_size" => "30",
                                               "error_message" => "Player number",
                                               "check_func" => "validPositiveInt",
                                               "setget" => "Number",
                                               "obj_type" => "player"));
$p->register("player_classrankid", "select", array("error_message" => "Player class",
                                                   "get_choices_array_func" => "getPlayerClassRankChoices",
                                                   "setget" => "Class",
                                                   "obj_type" => "player"));
$p->register("player_positionid", "select", array("error_message" => "Position",
                                                  "get_choices_array_func" => "getPositionChoices",
                                                  "get_choices_array_func_args" => array("player"),
                                                  "setget" => "Position",
                                                  "obj_type" => "player"));
$p->register("player_offdefst", "select", array("error_message" => "Offense/Defense/Special Teams",
                                                "get_choices_array_func" => "getOffDefStChoices",
                                                "setget" => "OffDefST",
                                                "obj_type" => "player"));
$p->register("player_height", "textbox", array("box_size" => "30",
                                               "error_message" => "Height",
                                               "check_func" => "validHeight",
                                               "setget" => "Height",
                                               "obj_type" => "player"));
$p->register("player_homelastschool", "textbox", array("box_size" => "30",
                                                       "setget" => "HomeLastSchool",
                                                       "error_message" => "Hometown/Last School",
                                                       "check_func" => "validShortText",
                                                       "obj_type" => "player"));
$p->register("player_bio", "textarea", array("error_message" => "Bio",
                                             "check_func" => "validLongText",
                                             "setget" => "Bio",
                                             "obj_type" => "player"));
$p->register("player_image", "file", array("filedir" => $path->getFilePath("image_player_basedir"),
                                           "filedir_webpath" => $path->getPath("image_player_basedir"),
                                           "setget" => "ImagePath",
                                           "error_message" => "Picture",
                                           "check_func" => "validPictureFile",
                                           "check_func_args" => array(true), // can have an empty picture file
                                           "obj_type" => "player"));
$p->register("player_weight", "textbox", array("box_size" => "30",
                                               "error_message" => "Weight",
                                               "setget" => "Weight",
                                               "check_func" => "validPositiveInt",
                                               "obj_type" => "player"));

// Mass Season-to-Season copy variables
// Need to register one ID variable per player and coach by team and season
if (   ($view == "index" && $p->submitIsSet("season_copy"))
    || ($view == "season_copy_index" && $p->submitIsSet("copy"))
    || ($view == "season_copy_error" && $p->submitIsSet("copy"))
    || ($view == "season_copy_confirm" && $p->submitIsSet("confirm"))) {
  // setup variables based on what is in the database
  $r = new Roster();
  $rs = new RosterStaff();
  $rarr = $r->findPlayersByTeamIDSeasonID($teamid, $seasonid);
  $rsarr = $rs->findCoachesByTeamIDSeasonID($teamid, $seasonid);

  $copy_varnames = array();
  while($r = $rarr->getOne()) {
    $vname = "copy_player_userid_" . $r->getID();
    $p->register($vname, "checkbox", array("on_text" => $r->getFName() . " " . $r->getLName(),
                                           "off_text" => "",
                                           "obj_type" => "copy"));
    array_push($copy_varnames, array("varname" => $vname, "ID" => $r->getID(), "type" => "player"));
  }
  while($r = $rsarr->getOne()) {
    $vname = "copy_staff_userid_" . $r->getID();
    $p->register($vname, "checkbox", array("on_text" => $r->getFName() . " " . $r->getLName(),
                                           "off_text" => ""));
    array_push($copy_varnames, array("varname" => $vname, "ID" => $r->getID(), "type" => "staff"));
  }
  unset($rarr);
  unset($rsarr);
}


///////////////////////////////////////////////////
// Determine state based on last view
///////////////////////////////////////////////////

switch($view) {
  case "index":     if ($p->submitIsSet("edit_staff"))   $state = "show_staff_index";
                elseif ($p->submitIsSet("edit_players")) $state = "show_player_index";
                elseif ($p->submitIsSet("season_copy"))  $state = "show_season_copy_index";
                else                                     $state = "undefined";
    break;
  case "staff_index":    if ($p->submitIsSet("delete") && RosterStaff::idExists($staff_userid)) $state = "show_confirm_delete_staff";
                     elseif (RosterStaff::idExists($staff_userid))                              $state = "show_staff_form";
                     elseif ($add == "1")                                                       $state = "show_staff_form";
                     else                                                                       $state = "undefined";
    break;
  case "player_index":     if ($p->submitIsSet("delete") && Roster::idExists($player_userid)) $state = "show_confirm_delete_player";
                       elseif (Roster::idExists($player_userid))                              $state = "show_player_form";
                       elseif ($add == "1")                                                   $state = "show_player_form";
                       else                                                                   $state = "undefined";
    break;
  case "staff_error":
  case "staff_form": if ($p->submitIsSet("save")) $state = "process_staff";
                     else                         $state = "undefined";
    break;
  case "player_error":
  case "player_form": if ($p->submitIsSet("save")) $state = "process_player";
                       else                         $state = "undefined";
    break;
  case "staff_success":     if (RosterStaff::idExists($staff_userid)) $state = "show_staff_form";
                        elseif ($stafflist == "1")                    $state = "show_staff_index";
                        else                                          $state = "show_index";
    break;
  case "player_success":    if (Roster::idExists($player_userid)) $state = "show_player_form";
                        elseif ($playerlist == "1")               $state = "show_player_index";
                        else                                      $state = "show_index";
    break;
  case "confirm_delete_staff":     if ($p->submitIsSet("yes") && RosterStaff::idExists($staff_userid)) $state = "process_delete_staff";
                               elseif ($p->submitIsSet("cancel"))                                      $state = "show_staff_index";
                               else                                                                    $state = "undefined";
    break;
  case "confirm_delete_player":    if ($p->submitIsSet("yes") && Roster::idExists($player_userid)) $state = "process_delete_player";
                               elseif ($p->submitIsSet("cancel"))                                  $state = "show_player_index";
                               else                                                                $state = "undefined";
    break;
  case "season_copy_error":
  case "season_copy_index":    if ($p->submitIsSet("copy"))   $state = "check_for_season_copy_overwrite";
                           elseif ($p->submitIsSet("cancel")) $state = "show_index";
                           else                               $state = "undefined";
    break;
  case "season_copy_confirm":    if ($p->submitIsSet("confirm"))  $state = "process_season_copy";
                             elseif ($p->submitIsSet("cancel"))   $state = "show_index";
                             else                                 $state = "undefined";
    break;
  default: $state = "show_index";
}

///////////////////////////////////////////////////
// Perform action based on state
///////////////////////////////////////////////////

if ($state == "show_index") {
  $view = "index";
}
elseif ($state == "show_staff_index") {
  if (Season::idExists($seasonid)) {
    $view = "staff_index";
  } else {
    $msg = "Error: Season Invalid";
    $view = "index";
  }
}
elseif ($state == "show_player_index") {
  if (Season::idExists($seasonid)) {
    $view = "player_index";
  } else {
    $msg = "Error: Season Invalid";
    $view = "index";
  }
}
elseif ($state == "show_season_copy_index") {
  $view = "season_copy_index";
}
elseif ($state == "show_confirm_delete_staff") {
  $view = "confirm_delete_staff";
}
elseif ($state == "show_staff_form") {
  $r = new RosterStaff($staff_userid);
  if ($add != 1) {
    $p->getVars($r, "staff");
  }
  $view = "staff_form";
}
elseif ($state == "show_confirm_delete_player") {
  $view = "confirm_delete_player";
}
elseif ($state == "show_player_form") {
  $r = new Roster($player_userid);
  if ($add != 1) {
    $p->getVars($r, "player");
  }
  $view = "player_form";
}
elseif ($state == "process_staff") {
  $p->checkVars("staff");
  if ($p->noErrors()) {
    if (strlen($staff_image) > 1 && !$p->fileMove("staff_image")) {
      $p->registerErr("staff_image", "Staff image invalid: Could not upload file!\n");
    }
  }
  if ($p->noErrors()) {
    $r = new RosterStaff($staff_userid);
    if ($staff_image == "") {
      $orig_path = $r->getImagePath();
    }
    $p->setVars($r, "staff");
    if ($staff_image == "") {
      $r->setImagePath($orig_path);
    }
    $r->setTeamID($teamid);
    $r->setSeasonID($seasonid);

    $r->save();

    $p->getVars($r, "staff");
    $view = "staff_success";
  } else {
    if (!$p->varHadError("staff_image")) {
      // cannot repopulate the file field, so inform the user that they must re-select the proper picture file
      $p->registerErr("staff_image", "If you were uploading a picture, you must re-select the file after an error");
    }
    $r = new RosterStaff($staff_userid);
    $staff_image = $r->getImagePath();
    $view = "staff_error";
  }
}
elseif ($state == "process_player") {
  $p->checkVars("player");
  if ($p->noErrors()) {
    if (strlen($player_image) > 1 && !$p->fileMove("player_image")) {
      $p->registerErr("player_image", "Player image invalid: Could not upload file!\n");
    }
  }
  if ($p->noErrors()) {
    $r = new Roster($player_userid);
    if ($player_image == "") {
      $orig_path = $r->getImagePath();
    }
    $p->setVars($r, "player");
    if ($player_image == "") {
      $r->setImagePath($orig_path);
    }
    $r->setTeamID($teamid);
    $r->setSeasonID($seasonid);

    $r->save();

    $p->getVars($r, "player");
    $view = "player_success";
  } else {
    if (!$p->varHadError("player_image")) {
      // cannot repopulate the file field, so inform the user that they must re-select the proper picture file
      $p->registerErr("player_image", "If you were uploading a picture, you must re-select the file after an error");
    }
    $r = new Roster($player_userid);
    $player_image = $r->getImagePath();
    $view = "player_error";
  }
}
elseif ($state == "process_delete_staff") {
  $r = new RosterStaff($staff_userid);
  $r->setActive("INACTIVE");
  $r->save();
  $msg = $r->getName() . " deleted successfully";
  $view = "staff_index";
}
elseif ($state == "process_delete_player") {
  $r = new Roster($player_userid);
  $r->setActive("INACTIVE");
  $r->save();
  $msg = $r->getFName() . " " . $r->getLName() . " deleted successfully";
  $view = "player_index";
}
elseif ($state == "check_for_season_copy_overwrite") {
  $p->checkVars("copy");
  $duplicates = array();
  $non_duplicates = array();
  foreach($copy_varnames as $c) {
    $varname = $c[varname];
    if ($$varname == "Y") { // checkbox was checked for this person
      if ($c[type] == "player") {
        $r = new Roster($c[ID]);
        $r->setSeasonID($copy_to_season);
      } else {
        $r = new RosterStaff($c[ID]);
        $r->setSeasonID($copy_to_season);
      }
      if ($r->duplicateExists()) {
        array_push($duplicates, $c);
      } else {
        array_push($non_duplicates, $c);
      }
    }
  }
  $view = "season_copy_confirm";
}
elseif ($state == "process_season_copy") {
  $p->checkVars("copy");
  foreach($copy_varnames as $c) {
    $varname = $c[varname];
    if ($$varname == "Y") { // checkbox was checked for this person
      if ($c[type] == "player") {
        $r = new Roster($c[ID]);
        $r->setSeasonID($copy_to_season);
        $r->setID(false);
      } else {
        $r = new RosterStaff($c[ID]);
        $r->setSeasonID($copy_to_season);
        $r->setID(false);
      }
      $r->save();
    }
  }
  $msg = "Copy Successful";
  $view = "index";
}
else {
  $view = "undefined";
}


///////////////////////////////////////////////////
// Setup template variables
///////////////////////////////////////////////////

if ($view == "index") {
  $p->getChoices();
  if (strlen($season) < 1)  {
    $setup = new Setup();
    $setup->loadCurrent();
    $seasonid = $setup->getActiveSeasonID(); // sets default season to be the current season
  }
}
elseif ($view == "staff_index") {
  $p->getChoices();
}
elseif ($view == "player_index") {
  $p->getChoices();
}
elseif ($view == "confirm_delete_staff") {
  $r = new RosterStaff($staff_userid);
  $name = $r->getName();
  $p->getChoices();
}
elseif ($view == "confirm_delete_player") {
  $r = new Roster($player_userid);
  $name = $r->getFName() . " " . $r->getLName();
  $p->getChoices();
}
elseif ($view == "staff_form" || $view == "staff_error") {
  $p->getChoices();
  if (strlen($staff_image) > 0) $picturepath = $path->getPath("image_coach_basedir") . "/" . $staff_image;
}
elseif ($view == "staff_success") {
  $p->getChoices();
  if (strlen($staff_image) > 0) $picturepath = $path->getPath("image_coach_basedir") . "/" . $staff_image;
}
elseif ($view == "player_form" || $view == "player_error") {
  $p->getChoices();
  if (strlen($player_image) > 0) $picturepath = $path->getPath("image_player_basedir") . "/" . $player_image;
}
elseif ($view == "player_success") {
  $p->getChoices();
  if (strlen($player_image) > 0) $picturepath = $path->getPath("image_player_basedir") . "/" . $player_image;
}
elseif ($view == "season_copy_index" || $view == "season_copy_form") {
  $p->getChoices();
}
elseif ($view == "season_copy_confirm") {
  $p->getChoices();
}

///////////////////////////////////////////////////
// Include template files based on view
///////////////////////////////////////////////////

switch($view) {
  case "index": include($path->getFilePath("template_admin_bios_index")); break;
  case "staff_index": include($path->getFilePath("template_admin_bios_staff_index")); break;
  case "player_index": include($path->getFilePath("template_admin_bios_player_index")); break;
  case "confirm_delete_staff": include($path->getFilePath("template_admin_bios_staff_confirm_delete")); break;
  case "confirm_delete_player": include($path->getFilePath("template_admin_bios_player_confirm_delete")); break;
  case "staff_error":
  case "staff_form": include($path->getFilePath("template_admin_bios_staff_form")); break;
  case "staff_success": include($path->getFilePath("template_admin_bios_staff_success")); break;
  case "player_error":
  case "player_form": include($path->getFilePath("template_admin_bios_player_form")); break;
  case "player_success": include($path->getFilePath("template_admin_bios_player_success")); break;
  case "season_copy_error":
  case "season_copy_index": include($path->getFilePath("template_admin_bios_copy_index")); break;
  case "season_copy_confirm": include($path->getFilePath("template_admin_bios_copy_confirm")); break;
  default: include($path->getFilePath("template_undefined"));
}
