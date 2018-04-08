<?
include_once(dirname(__FILE__) . "/../../../include/Page/class_path.php");
$path = new Path();
include_once($path->getFilePath("class_page"));
include_once($path->getFilePath("class_coach_question"));
include_once($path->getFilePath("class_setup"));
include_once($path->getFilePath("tools_sendmail"));

$p = new Page("mobile", "public", "page_askcoach");

/////////////////////////////
// Register Form Variables //
/////////////////////////////

$p->register("submit", "submit", 
             array(       "setget" => "none",
                           "value" => "Submit"));
$p->register("name", "textbox",
             array(       "setget" => "Name",
                        "box_size" => 39,
                      "check_func" => "validShortText",
                 "check_func_args" => array(true),
                   "error_message" => "Name"));
$p->register("email", "textbox",
             array(       "setget" => "Email",
                        "box_size" => 39,
                      "check_func" => "validShortText",
                 "check_func_args" => array(true),
                   "error_message" => "Email"));
$p->register("hometown", "textbox",
             array(       "setget" => "Hometown",
                        "box_size" => 39,
                      "check_func" => "validShortText",
                 "check_func_args" => array(true),
                   "error_message" => "Hometown"));
$p->register("question", "textarea",
             array(       "setget" => "Question",
                          "cols" => "25",
                          "rows" => "5",
                      "check_func" => "validLengthText",
                 "check_func_args" => array(255, false),
                   "error_message" => "Question"));

//////////////////////////////
// Decide operational state //
//////////////////////////////

switch($view) {
  case "index":
  case "error": if ($p->submitIsSet("submit")) $state = "process";
                else                           $state = "index";
    break;
  case "success":
  default: $state = "index";
}

////////////////////////////////////////
// Decide next view, and process data //
////////////////////////////////////////

if($state == "index") {
  $view = "index";
}
else if ($state == "process")
{
  $p->checkVars();
  if (!$p->noErrors()) {
    $view = "error";
  } else {
    // Save question in the database
    $x = new CoachQuestion();
    $p->setVars($x);
    $s = new Setup();
    $s->loadCurrent();
    $x->setGameid($s->getActiveGameid());
    $x->setActive("ACTIVE");
    $x->save();

    // send email to coach's representative
    $notify = "A new question has been posted for Coach Tiller!\n"
            . "\n"
            . "Name:  $name\n"
            . "E-mail:  $email\n"
            . "Hometown:  $hometown\n"
            . "Question:\n"
            . "$question\n";
    $notify = wordwrap($notify, 70);
    sendMail(array(array("address" => $path->getEmail("email_askcoach"), "name" => "eStadium Ask the Coach")), array(),
             "[eStadium Ask the Coach] Message #".$x->getQuestionid(), $notify);

    // send email to the person
    $thanks = "Thank you for your question to Coach Tiller!  Here is a summary of your question:\n"
            . "Name:  $name\n"
            . "E-mail:  $email\n"
            . "Hometown:  $hometown\n"
            . "Question:\n"
            . "$question\n"
            . "\n";
/*            . "Be sure to check our <a href=\"".$path->getFullWebPath("page_askcoach_answers")."\">"
            . "'Ask the Coach' Answers</a> next week to see if your question was answered\n"
            . "by Coach Tiller on his weekly television show!\n"; */ // can only do the link above if we have HTML mail headers
    $thanks = wordwrap($thanks, 70);
    if (isset($email))  {
      $ret = sendMail(array(array("address" => $email, "name" => "")), array(),
               "Thank you for your question!", $thanks);
    }
    $view = "success";
  }
} else {
  $view = "undefined";
}

switch($view)
{
    case "index":
    case "error": include($path->getFilePath("template_askcoach_index"));
                   break;
  case "success": include($path->getFilePath("template_askcoach_success"));
                  break;
         default: include($path->getFilePath("template_undefined"));
}

?>
