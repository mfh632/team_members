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
define('TMEMBERS_OPTION_POST_TYPE_URL', 'tmembers_post_type_url');
define('TMEMBERS_DEFAULT_POST_TYPE_URL', 'team-members');

require_once('autoload.php');

\Team\Members\Settings::create_instance();
\Team\Members\PostType::create_instance();
\Team\Members\CustomField::create_instance();
\Team\Members\Shortcode::create_instance();


/**
 * Post type team_members full url
 *
 * @return string|void
 */
function tmembers_get_team_members_url(){
    $path = tmembers_get_team_members_path();
    return site_url($path);
}

/**
 * Post type team_members url path
 *
 * @return false|mixed|string|void
 */
function tmembers_get_team_members_path(){
    if ($path = get_option(TMEMBERS_OPTION_POST_TYPE_URL)){
        return $path;
    }
    return TMEMBERS_DEFAULT_POST_TYPE_URL;
}