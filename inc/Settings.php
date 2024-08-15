<?php
namespace Team\Members;

class Settings extends BaseComponent
{
    protected const OPTION_GROUP_TEAM_MEMBER_SETTING = 'tmembers_group_team_member_setting';

    public const OPTION_IS_SHOW_SEE_ALL = 'tmembers_is_show_see_all';
    public const OPTION_NUMBER_OF_ITEM = 'tmembers_number_of_item';
    public const OPTION_POST_TYPE_URL = 'tmembers_post_type_url';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'settings_init']);
        add_action('init', [$this, 'tmembers_post_type']);
        add_filter( 'single_template', [$this, 'tmembers_single_template'] ) ;
        add_filter( 'archive_template', [$this, 'tmembers_archive_template'] ) ;
        add_action( 'pre_get_posts' ,[$this,'tmembers_query_post_type_team_members'], 1, 1 );
    }

    public function tmembers_post_type(){
        $slug = get_option(self::OPTION_POST_TYPE_URL, '') ?? 'team-members';
        register_post_type('team_members',[
            'labels' => [
                'name' => __('Team Members', 'tmembers'),
                'singular_name' => __('Team Member', 'tmembers'),
                'add_new_item' => __( 'Add New Team Member', 'tmembers' ),
                'add_new' => __( 'Add New Member', 'tmembers' ),
            ],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array( 'slug' => $slug),
            'supports' => array(''),
        //    'taxonomies' => array( 'member_type'),
        ]);

        $this->tmembers_member_type();
    }

    /**
     * Add member_type taxonomies
     */
    public function tmembers_member_type() {
        $labels = array(
            'name' => _x( 'Member Type', 'taxonomy general name' ),
            'singular_name' => _x( 'Member Type', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Member Types' ),
            'all_items' => __( 'All Member Types' ),
            'parent_item' => __( 'Parent Member Type' ),
            'parent_item_colon' => __( 'Parent Member Type:' ),
            'edit_item' => __( 'Edit Member Type' ),
            'update_item' => __( 'Update Member Type' ),
            'add_new_item' => __( 'Add New Member Type' ),
            'new_item_name' => __( 'New Member Type' ),
            'menu_name' => __( 'Member Type' ),
        );
        register_taxonomy(
            'member_type',
            'team_members',
            array(
                'labels' => $labels,
                'rewrite' => array( 'slug' => 'member-type' ),
                'hierarchical' => true,
            )
        );
    }


    public function settings_init(){
        register_setting(
            self::OPTION_GROUP_TEAM_MEMBER_SETTING,
            self::OPTION_IS_SHOW_SEE_ALL
        );


        add_settings_section(
            'tmembers_is_show_see_all_section',
            'Teem Members Settings',
            null,
            'tmembers_is_show_see_all'
        );

        add_settings_field(
            self::OPTION_IS_SHOW_SEE_ALL,
            'Is Show See All Button',
            [$this, 'render_is_show_all'],
            'tmembers_is_show_see_all',
            'tmembers_is_show_see_all_section'
        );

        register_setting(
            self::OPTION_GROUP_TEAM_MEMBER_SETTING,
            self::OPTION_NUMBER_OF_ITEM
        );

        add_settings_field(
            self::OPTION_NUMBER_OF_ITEM,
            'Show Number of tema member',
            [$this, 'render_number_of_team_member'],
            'tmembers_is_show_see_all',
            'tmembers_is_show_see_all_section'
        );

        register_setting(
            self::OPTION_GROUP_TEAM_MEMBER_SETTING,
            self::OPTION_POST_TYPE_URL
        );

        add_settings_field(
            self::OPTION_POST_TYPE_URL,
            'Team Member Post Type URL',
            [$this, 'render_tm_pt'],
            'tmembers_is_show_see_all',
            'tmembers_is_show_see_all_section'
        );

    }

    public function render_is_show_all(){
        $value = get_option(self::OPTION_IS_SHOW_SEE_ALL, '');
        echo '<input type="checkbox" name="' . self::OPTION_IS_SHOW_SEE_ALL . '" value="1" '. checked(1, $value, false).'>';
    }

    public function render_number_of_team_member(){
        $value = get_option(self::OPTION_NUMBER_OF_ITEM, '');
        echo '<input type="number" name="' . self::OPTION_NUMBER_OF_ITEM . '" value="'. $value .'">';
    }

    public function render_tm_pt(){
        $value = get_option(self::OPTION_POST_TYPE_URL, '');
        echo '<input type="text" name="' . self::OPTION_POST_TYPE_URL . '" value="'. $value .'">';
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

    public function team_members_setting(){
        require_once(TMEMBERS_PLUGIN_DIR . '/templates/settings.php');
    }

    public function tmembers_single_template($single_template){
        global $post;

        if ( 'team_members' === $post->post_type ) {
            $single_template = TMEMBERS_PLUGIN_DIR . '/templates/single-team_members.php';
        }

        return $single_template;
    }

    function tmembers_archive_template( $archive_template ) {
        global $post;

        if ( is_post_type_archive ( 'team_members' ) ) {
            $archive_template = TMEMBERS_PLUGIN_DIR . '/templates/archive-team_members.php';
        }
        return $archive_template;
    }

    public function tmembers_query_post_type_team_members($query){
        if ( ! is_admin() && is_post_type_archive( 'team_members' ) && $query->is_main_query() )
        {
            $query->set( 'posts_per_page', 8 );
        }
    }
}