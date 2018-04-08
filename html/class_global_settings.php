<?

class GlobalSettings {
  function load($type="capture", $make_global_vars=false) {
    global $SETTINGS;

    // Setup new game
    $setup[gameid] = 15;
    $setup[gamenumber] = 15;

    // Capture computer
    #TODO: Update for new install location (and new conversion software)
    $cap[season]=2009;
    $cap[game_num_to_sync]=$setup[gamenumber];
    $cap[gamedir]="/$cap[season]/G$cap[game_num_to_sync]/";
    $cap[local_video_directory]="/Users/vip/estadium/gt09/site/videos";
    $cap[remote_video_directory]="estad@vipmac.vip.gatech.edu:/Users/estad/gt09/site/videos";
    $cap[watch_enc_dirs]= array( "raw/" ); // Where the capture computer puts files
    $cap[trans_dirs]= array( "mobile_mp4/", "small_3gp/"
					//, "mobile_wmv/"
						 ); // Where the encoding computer puts files
    $cap[copy_dirs]= array( "pc_mp4/", "small_mp4/", "mobile_3gp/" ); // Where the import script copy's files (i.e. mp4 to 3gp)
    $cap[all_video_dirs] = array_merge($cap[trans_dirs], $cap[watch_enc_dirs], $cap[copy_dirs]); // All video encoding dirs
    $cap[quarter_dirs]= array("Q7/", "Q6/", "Q5/", "Q4/", "Q3/", "Q2/", "Q1/", "Pregame/", "Halftime/", "Postgame/", "Other/");

    // Encoding computer


  //  $enc[local_video_directory]="/Users/estad/gt09/site/videos/";
   // $enc[remote_video_directory]="estad@estadium.vip.gatech.edu:/www/html/videos/";
    $enc[local_video_directory]="/Users/estad/gt09/site/videos/";
    $enc[remote_video_directory]="estad@estadium.vip.gatech.edu:/www/html/videos/";



    $enc[watch_enc_dirs] = $cap[watch_enc_dirs];
    $enc[quarter_dirs] = $cap[quarter_dirs];
    $enc[trans_dirs] = $cap[trans_dirs];
    $enc[all_video_dirs] = $cap[all_video_dirs];
    $enc[transcode_extensions]=array("raw/" => "mp4",
                                     "small_mp4/" => "mp4",
                                     "small_3gp/" => "3gp",
                                     "mobile_mp4/" => "mp4",
                                     "mobile_3gp/" => "3gp",
                                    // "mobile_wmv/" => "wmv",
                                   "pc_mp4/" => "mp4");

    // Squeeze setup on encoding computer
    $sqz[replace_path]=preg_replace("/\//", "\/", $enc[local_video_directory] . GlobalSettings::noTrailingSlash($cap[gamedir]));
    $sqz[squeezefiles_dir]="/Users/estad/gt09/scripts/encode/squeeze_files";


    // Video server, import script<
    $imp[remote_video_directory] = "/www/html/videos/$cap[season]/G$cap[game_num_to_sync]";

    $imp[local_video_directory] = "/www/html/videos/$cap[season]/G$cap[game_num_to_sync]";

    $imp[game_num_to_sync] = $cap[game_num_to_sync];
    $imp[enc_dirs] = $cap[all_video_dirs];
    $imp[quarter_dirs] = $cap[quarter_dirs];
    $imp[transcode_extensions] = $enc[transcode_extensions];
    $imp[copy_dirs_info]=array(array("oldext" => "mp4",
                                     "newext"  => "3gp",
                                     "olddir"  => "mobile_mp4/",
                                     "newdir"  => "mobile_3gp/"),
                               array("oldext" => "mp4",
                                     "newext"  => "mp4",
                                     "olddir"  => "raw/",
                                     "newdir"  => "pc_mp4/"),
                               array("oldext" => "3gp",
                                     "newext" => "mp4",
                                     "olddir" => "small_3gp/",
                                     "newdir" => "small_mp4/"),
                               array("oldext" => "mp4",
                                     "newext" => "mp4",
                                     ));

    // Stats importer
    $stat[stats_file] = realpath(dirname(__FILE__)."/../../scripts/stats_import/geot.xml");

    // Main website
    $site[trans_dirs] = array_merge($cap[trans_dirs], $cap[copy_dirs]); // all dirs except raw
    $site[transcode_extensions] = $enc[transcode_extensions];

    // Capture computer variables
    if ($type == "capture") {
      $SETTINGS = array( "GAME_NUM_TO_SYNC" => $cap[game_num_to_sync],
                         "SEASON"           => $cap[season],
                         "LOCAL_DIRECTORY"  => GlobalSettings::noTrailingSlash($cap[local_video_directory]),
                         "DIRS"             => GlobalSettings::noTrailingSlash($cap[quarter_dirs]),
                         "ENCODINGS"        => GlobalSettings::noTrailingSlash($cap[all_video_dirs]),
                         "REMOTE_DIRECTORY" => $cap[remote_video_directory]
                       );
    }

    // Encoding computer variables
    elseif ($type == "encode_bash") {
      $SETTINGS = array( "GAME_NUM_TO_SYNC" => $cap[game_num_to_sync],
                         "SEASON"           => $cap[season],
                         "LOCAL_DIRECTORY"  => GlobalSettings::noTrailingSlash($enc[local_video_directory]),
                         "REMOTE_DIRECTORY" => GlobalSettings::noTrailingSlash($enc[remote_video_directory]),
                         "DIRS"             => GlobalSettings::noTrailingSlash($cap[quarter_dirs]),
                         "ENCODINGS"        => GlobalSettings::noTrailingSlash($cap[all_video_dirs])
                       );
    }
    elseif ($type == "encode") {
      $SETTINGS = array(
                         "local_videos_dir" => GlobalSettings::trailingSlash($enc[local_video_directory] . "$cap[gamedir]"),
                         "quarter_dirs"     => GlobalSettings::trailingSlash($enc[quarter_dirs]),
                         "watch_enc_dirs"   => GlobalSettings::trailingSlash($enc[watch_enc_dirs]),
                         "trans_dirs"       => GlobalSettings::trailingSlash($enc[trans_dirs]),
                         "transcode_extensions" => $enc[transcode_extensions],
                         "season"           => $cap[season],
                         "gamenum"          => $cap[game_num_to_sync],
                         "squeezefiles_dir" => GlobalSettings::trailingSlash($sqz[squeezefiles_dir])
                       );
    }
    elseif ($type == "setup_squeeze") {
      $SETTINGS = array( "GAME_NUM_TO_SYNC" => $cap[game_num_to_sync],
                         "SEASON"           => $cap[season],
                         "DIRS"             => GlobalSettings::noTrailingSlash($cap[quarter_dirs]),
                         "ENCODINGS"        => GlobalSettings::noTrailingSlash($cap[trans_dirs]),
                         "REPLACE_PATH"     => $sqz[replace_path],
                         "SQUEEZEFILES_DIR" => $sqz[squeezefiles_dir]
                       );
    }

    elseif ($type == "import_video") {
      $SETTINGS = array("local_videos_dir" => GlobalSettings::trailingSlash($imp[local_video_directory]),
                        "quarter_dirs"     => GlobalSettings::trailingSlash($imp[quarter_dirs]),
                        "enc_dirs"         => GlobalSettings::trailingSlash($imp[enc_dirs]),
                        "transcode_extensions" => $imp[transcode_extensions],
                        "copy_dirs_info"   => $imp[copy_dirs_info],
                        "game_num_to_sync" => $imp[game_num_to_sync]
                       );
    }
    elseif ($type == "import_bash") { // runs on jeff server
      $SETTINGS = array( "GAME_NUM_TO_SYNC" => GlobalSettings::noTrailingSlash($cap[game_num_to_sync]),
                         "SEASON"           => GlobalSettings::noTrailingSlash($cap[season]),
                         "LOCAL_DIRECTORY"  => GlobalSettings::noTrailingSlash($imp[local_video_directory]),
                         "DIRS"             => GlobalSettings::noTrailingSlash($cap[quarter_dirs]),
                         "ENCODINGS"        => GlobalSettings::noTrailingSlash($cap[all_video_dirs])
                       );
    }
    elseif ($type == "site_links") { // used in Check::contructVideoLink
      $SETTINGS = array("trans_dirs" => GlobalSettings::trailingSlash($site[trans_dirs]),
                        "transcode_extensions" => $site[transcode_extensions]
                       );
    }
    elseif ($type == "watch_stats") {
      $SETTINGS = array("LOCAL_STATS_DIR" => GlobalSettings::noTrailingSlash($stat[top_stats_dir])
                       );
    }
    elseif ($type == "stats") {
      $SETTINGS = array("stats_file" => $stat[stats_file]
                       );
    }
    elseif ($type == "setup_game") {
      $SETTINGS = array("gameid" => $setup[gameid],
                        "gamenumber" => $setup[game_num_to_sync]
                       );
    }
    else {
      echo "ERROR: $type is not a recognized global settings category!\n";
    }
    if ($make_global_vars != false) {
      foreach($SETTINGS as $key => $value) {
        global $$key;
        $$key = $value;
      }
    }
  }

  function trailingSlash($str_or_array) {
    if (is_array($str_or_array)) {
      foreach($str_or_array as $key => $value) {
        $str_or_array[$key] = (preg_match("/\/$/", $value) ? $value : ($value . "/"));
      }
      return $str_or_array;
    }
    return (preg_match("/\/$/", $str_or_array) ? $str_or_array : ($str_or_array . "/"));
  }

  function noTrailingSlash($str_or_array) {
    if (is_array($str_or_array)) {
      foreach($str_or_array as $key => $value) {
        $str_or_array[$key] = preg_replace("/\/$/", "", $value);
      }
      return $str_or_array;
    }
    return preg_replace("/\/$/", "", $str_or_array);
  }
}


