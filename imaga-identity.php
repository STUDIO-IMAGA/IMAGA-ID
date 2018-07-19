<?php

/*
Plugin Name: IMAGA Identity
Description: IMAGA Site Identity
Version: 2.0.0
Author: IMAGA
Author URI: http://imaga.nl/
Text Domain: imaga-identity
*/

$files = [
  'lib/setup.php',
  'lib/login.php',
  'lib/dashboard.php',
];

foreach ($files as $file) {
  if ( !$path = dirname( __FILE__ ) .'/'. $file ) {
    trigger_error(sprintf(__('Error: could not include %s', 'imaga-id'), $file), E_USER_ERROR);
  }
  require_once $path;
}
unset($file, $path);
