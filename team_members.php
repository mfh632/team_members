<?php

/**
 * Plugin Name: Team Members
 * Plugin URI: https://wordpress661.test
 * Description: A custom plugin for post type team_members
 * Version: 1.0.0
 * Author: Fizul Haque
 * Author URI: https://fhaque.com.bd
 * License: GPL2
 * Text Domain: tmembers
 */

define('TMEMBERS_PLUGIN_DIR', dirname(__FILE__));
define('TMEMBERS_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once('autoload.php');

\Team\Members\Settings::create_instance();
\Team\Members\CustomField::create_instance();
\Team\Members\Shortcode::create_instance();
