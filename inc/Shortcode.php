<?php

namespace Team\Members;
/**
 * Class Shortcode
 * @package Team\Members
 */
class Shortcode extends BaseComponent
{
    public function __construct()
    {
        add_shortcode('team_members', [$this, 'load_request_shortcode']);
    }

    public function load_request_shortcode()
    {
        ob_start();
        include(TMEMBERS_PLUGIN_DIR . '/templates/team_members.php');
        return ob_get_clean();
    }
}
