<?php


namespace Team\Members;


use function Sodium\add;

class CustomField extends BaseComponent
{
    public function __construct()
    {
        add_action( 'add_meta_boxes', [$this, 'tmembers_custom_meta_box']);
        add_action( 'save_post', [$this, 'tmembers_save_postdata']);

        /** Manage columns */
        add_filter('manage_team_members_posts_columns', [$this,'tememers_add_team_members_columns']);

        /** Manage columns */
        add_filter('manage_edit-team_members_sortable_columns', [$this, 'tmembers_sortable_columns']);

        /** Populate column cells */
        add_action( 'manage_team_members_posts_custom_column' , [$this,'tememers_team_members_column'],10, 2);

        /** Set query to sort */
        add_action('pre_get_posts', [$this, 'tmembers_pre_get_posts']);
    }

    /**
     * Set team members meta box
     */
    public function tmembers_custom_meta_box() {
        $screens = [ 'team_members'];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'tmembers_position',                 // Unique ID
                'Position',      // Box title
                [$this, 'tmember_position_meta_box_html'],  // Content callback, must be of type callable
                $screen                            // Post type
            );


        }
    }

    public function tmember_position_meta_box_html( $post ) {
        $value = get_post_meta( $post->ID, 'tmembers_position', true );

        ?>
        <div class="mb-3">
            <label for="tmembers_position" class="form-label">Position</label>
            <input type="text" class="form-control" name="tmembers_position" id="tmembers_position" value="<?= $value; ?>" />
        </div>

        <?php
    }

    public function tmembers_save_postdata( $post_id ) {

        if ( array_key_exists( 'tmembers_position', $_POST ) ) {
            update_post_meta(
                $post_id,
                'tmembers_position',
                $_POST['tmembers_position']
            );
        }

    }

    /**
     * Set team member custom columns
     *
     * @param $columns
     * @return array
     */
    public function tememers_add_team_members_columns($columns) {
        $date = $columns['date'];

        // unset the 'date' column
        unset( $columns['date'] );

        return array_merge(
            $columns,
            [
                'title' => __("Name"),
                'tmembers_position' => __("Position"),
                'date' => $date
            ]
        );
    }

    /**
     * Set team member custom columns value
     *
     * @param $column
     * @param $post_id
     */
    public function tememers_team_members_column( $column, $post_id ) {
        switch ( $column ) {
            case 'tmembers_position':
                echo get_post_meta( $post_id , 'tmembers_position' , true );
                break;
        }
    }

    public function tmembers_sortable_columns($columns){
        $columns['tmembers_position'] = [
            'tmembers_position',
            false,
            __('Position'),
            __('Table ordered by Position')
        ];

        return $columns;
    }

    public function tmembers_pre_get_posts($query) {
        if (!is_admin()) {
            return;
        }
        $orderby = $query->get('orderby');

        if ($orderby == 'tmembers_position') {

            $query->set('meta_key', 'tmembers_position');
            $query->set('orderby', 'meta_value');
        }
    }
}