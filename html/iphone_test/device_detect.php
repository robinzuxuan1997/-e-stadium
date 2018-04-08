<?php

class DeviceDetect {

      static function ismobile() {
            $is_mobile = '0';

            if (preg_match('/(android|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                  $is_mobile = 1;
            }

            if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
                  $is_mobile = 1;
            }

            $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
            $mobile_agents = array('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'andr', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');

            if (in_array($mobile_ua, $mobile_agents)) {
                  $is_mobile = 1;
            }

            if (isset($_SERVER['ALL_HTTP'])) {
                  if (strpos(strtolower($_SERVER['ALL_HTTP']), 'OperaMini') > 0) {
                        $is_mobile = 1;
                  }
            }

            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') > 0) {
                  $is_mobile = 0;
            }

            return $is_mobile;
      }

      static function isiphone() {
            $iphone = 0;
            if (preg_match('/iphone/', strtolower(strtolower($_SERVER['HTTP_USER_AGENT'])))) {
                  $iphone = 1;
            }
            return $iphone;
      }

      static function isipad() {
            $ipad = 0;
            if (preg_match('/ipad/', strtolower(strtolower($_SERVER['HTTP_USER_AGENT'])))) {
                  $ipad = 1;
            }
            return $ipad;
      }

      static function isAndroid(){
            $android = 0;
            if (preg_match('/android/', strtolower(strtolower($_SERVER['HTTP_USER_AGENT'])))) {
                  $android = 1;
            }
            return $android;
      }

}

?>
