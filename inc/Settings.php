<?php
namespace Team\Members;

class Settings extends BaseComponent
{
    protected const OPTION_GROUP_TEAM_MEMBER_SETTING = 'tmembers_group_team_member_setting';

    public const OPTION_IS_DISABLE_SEE_ALL = 'tmembers_is_disable_see_all';
    public const OPTION_NUMBER_OF_ITEM = 'tmembers_number_of_item';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'settings_init']);
    }



    /**
     * Add Team Member Setting Options
     */
    public function settings_init(){
        register_setting(
            self::OPTION_GROUP_TEAM_MEMBER_SETTING,
            self::OPTION_IS_DISABLE_SEE_ALL
        );


        add_settings_section(
            'tmembers_shortcode_section',
            'Teem Members Shortcode Setting',
            null,
            'team_members_setting'
        );

        add_settings_field(
            self::OPTION_IS_DISABLE_SEE_ALL,
            'Is Disable See All Button',
            [$this, 'render_is_show_all'],
            'team_members_setting',
            'tmembers_shortcode_section'
        );

        register_setting(
            self::OPTION_GROUP_TEAM_MEMBER_SETTING,
            self::OPTION_NUMBER_OF_ITEM
        );

        add_settings_field(
            self::OPTION_NUMBER_OF_ITEM,
            'Show Number of tema member',
            [$this, 'render_number_of_team_member'],
            'team_members_setting',
            'tmembers_shortcode_section'
        );

        register_setting(
            self::OPTION_GROUP_TEAM_MEMBER_SETTING,
            TMEMBERS_OPTION_POST_TYPE_URL
        );

        add_settings_section(
            'tmembers_post_type_url_section',
            'Teem Members Post Type Setting',
            null,
            'team_members_setting'
        );

        add_settings_field(
            TMEMBERS_OPTION_POST_TYPE_URL,
            'Team Member Post Type URL',
            [$this, 'render_tm_pt'],
            'team_members_setting',
            'tmembers_post_type_url_section'
        );

    }

    public function render_is_show_all(){
        $value = get_option(self::OPTION_IS_DISABLE_SEE_ALL, '');
        echo '<input type="checkbox" name="' . self::OPTION_IS_DISABLE_SEE_ALL . '" value="1" '. checked(1, $value, false).'>';
    }

    public function render_number_of_team_member(){
        $value = get_option(self::OPTION_NUMBER_OF_ITEM, '');
        echo '<input type="number" name="' . self::OPTION_NUMBER_OF_ITEM . '" value="'. $value .'">';
    }

    public function render_tm_pt(){
        $value = get_option(TMEMBERS_OPTION_POST_TYPE_URL, '');
        echo "<p style='margin-bottom: 5px; color:#d01b1b;'>" . __('Default URL: ') ." <strong>". TMEMBERS_DEFAULT_POST_TYPE_URL."</strong></p>";
        echo '<input type="text" name="' . TMEMBERS_OPTION_POST_TYPE_URL . '" value="'. $value .'">';
    }

    public function add_admin_menu(){
        add_menu_page(
            'Team Members Setting',
            'Team Members Setting',
            'manage_options',
            'team_members_setting',
            [$this, 'team_members_setting']
        );
    }

    /**
     * Set team member setting template
     */
    public function team_members_setting(){
        require_once(TMEMBERS_PLUGIN_DIR . '/templates/settings.php');
    }

}