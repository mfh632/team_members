<?php

namespace Team\Members;

/**
 * Class PostType
 * @package Team\Members
 */
class PostType extends BaseComponent
{
    public const OPTION_POST_TYPE_URL = 'tmembers_post_type_url';

    public function __construct(){
        add_action('init', [$this, 'tmembers_post_type']);
        add_filter( 'single_template', [$this, 'tmembers_single_template'] ) ;
        add_filter( 'archive_template', [$this, 'tmembers_archive_template'] ) ;
        add_action( 'pre_get_posts' ,[$this,'tmembers_query_post_type_team_members'], 1, 1 );
        add_filter('enter_title_here', [$this,'tmembers_title_place_holder']);
        add_action( 'admin_head', [$this,'tmembers_replace_default_featured_image_meta_box']);
        add_action( 'admin_post_thumbnail_html', [$this,'tmembers_replace_default_featured_image_text']);
    }

    /**
     * Add Team Member Post Type
     */
    public function tmembers_post_type(){
        $slug = tmembers_get_team_members_path();

        $labels = [
            'name' => _x( 'Team Members', 'Post Type General Name', 'tmembers' ), // Set your Custom plural post name
            'singular_name' => _x( 'Team Member', 'Post Type Singular Name', 'tmembers' ), // Set your Custom singular post name
            'menu_name' => __( 'Team Members', 'tmembers' ),
            'name_admin_bar'=> __( 'Team Member', 'tmembers' ),
            'archives' => __( 'Team Member Archives','tmembers' ),
            'attributes'=> __( 'Team Member Attributes', 'tmembers' ),
            'all_items' => __( 'All Team Members', 'tmembers' ),
            'add_new_item' => __( 'Add New Team Member', 'tmembers' ),
            'add_new'  => __( 'Add New', 'tmembers' ),
            'new_item' => __( 'New Team Member', 'tmembers' ),
            'edit_item' => __( 'Edit Team Member', 'tmembers' ),
            'update_item'=> __( 'Update Team Member', 'tmembers' ),
            'view_item' => __( 'View Team Member', 'tmembers' ),
            'search_items' => __( 'Search Team Member', 'tmembers' ),
            'not_found' => __( 'Not found', 'tmembers' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'tmembers' )
        ];

        register_post_type('team_members',[
            'labels' => $labels,
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array( 'slug' => $slug),
            'supports' => array('title', 'editor', 'thumbnail'),
            //    'taxonomies' => array( 'member_type'),
        ]);

        /** member_type taxonomies */
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

    /**
     * Set Team member single post template
     *
     * @param $single_template
     * @return mixed|string
     */
    public function tmembers_single_template($single_template){
        global $post;

        if ( 'team_members' === $post->post_type ) {
            $single_template = TMEMBERS_PLUGIN_DIR . '/templates/single-team_members.php';
        }

        return $single_template;
    }

    /**
     * Set Team member archive template
     *
     * @param $archive_template
     * @return mixed|string
     */
    function tmembers_archive_template( $archive_template ) {
        global $post;

        if ( is_post_type_archive ( 'team_members' ) ) {
            $archive_template = TMEMBERS_PLUGIN_DIR . '/templates/archive-team_members.php';
        }
        return $archive_template;
    }

    /**
     * Set Team member paginate default per page qty
     *
     * @param $query
     */
    public function tmembers_query_post_type_team_members($query){
        if ( ! is_admin() && is_post_type_archive( 'team_members' ) && $query->is_main_query() )
        {
            $query->set( 'posts_per_page', 8 );
        }
    }

    public function tmembers_title_place_holder($title){
        if (get_post_type() === "team_members"){
            return __('Enter Team Member Name');
        }

        return $title;
    }

    /**
     *  Change the featured image metabox title text
     */
    public function tmembers_replace_default_featured_image_meta_box() {
        remove_meta_box( 'postimagediv', 'team_members', 'side' );
        add_meta_box('postimagediv', __('Add a member picture'), 'post_thumbnail_meta_box', 'team_members', 'side', 'high');
    }

    public function tmembers_replace_default_featured_image_text( $content ) {
        if ( 'team_members' === get_post_type() ) {
            $content = str_replace( 'Set featured image', __( 'Set Member Picture', 'tmembers' ), $content );
            $content = str_replace( 'Remove featured image', __( 'Remove Member Picture', 'tmembers' ), $content );
        }
        return $content;
    }

}