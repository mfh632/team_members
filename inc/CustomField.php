<?php


namespace Team\Members;


class CustomField extends BaseComponent
{
    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', [$this,'tmembers_include_myuploadscript']);
        add_action( 'add_meta_boxes', [$this, 'tmembers_custom_meta_box']);
        add_action( 'save_post', [$this, 'tmembers_save_postdata']);
        add_filter('manage_team_members_posts_columns', [$this,'tememers_add_team_members_columns']);
        add_action( 'manage_team_members_posts_custom_column' , [$this,'tememers_team_members_column'],10, 2);
    }

    public function tmembers_custom_meta_box() {
        $screens = [ 'team_members'];
        foreach ( $screens as $screen ) {

            add_meta_box(
                'tmembers_name',                 // Unique ID
                'Name',      // Box title
                [$this, 'tmember_name_meta_box_html'],  // Content callback, must be of type callable
                $screen                            // Post type
            );
            add_meta_box(
                'tmembers_picture',                 // Unique ID
                'Picture',      // Box title
                [$this, 'tmember_picture_meta_box_html'],  // Content callback, must be of type callable
                $screen                            // Post type
            );

            add_meta_box(
                'tmembers_bio',                 // Unique ID
                'Bio',      // Box title
                [$this, 'tmember_bio_meta_box_html'],  // Content callback, must be of type callable
                $screen                            // Post type
            );

            add_meta_box(
                'tmembers_position',                 // Unique ID
                'Position',      // Box title
                [$this, 'tmember_position_meta_box_html'],  // Content callback, must be of type callable
                $screen                            // Post type
            );


        }
    }

    public function tmember_name_meta_box_html( $post ) {
        $value = get_post_meta( $post->ID, 'tmembers_name', true );
        ?>
        <div class="mb-3">
            <label for="tmembers_name" class="form-label">Name</label>
            <input type="text" class="form-control" name="tmembers_name" id="tmembers_name" value="<?= $value; ?>" />
        </div>

        <?php
    }
    public function tmember_picture_meta_box_html( $post ) {
        $meta_key = 'tmembers_picture';
        $value = get_post_meta( $post->ID, $meta_key, true );
        $name = "tmembers_picture";

        echo $this->tmembers_image_uploader_field( $meta_key, $value);
    }

    public function tmember_bio_meta_box_html( $post ) {
        $value = get_post_meta( $post->ID, 'tmembers_bio', true );
        echo $value;
        ?>
        <div class="mb-3">
            <label for="tmembers_bio" class="form-label">Bio</label>
            <input type="text" class="form-control" name="tmembers_bio" id="tmembers_bio"  />
        </div>

        <?php
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
        if ( array_key_exists( 'tmembers_name', $_POST ) ) {
            update_post_meta(
                $post_id,
                'tmembers_name',
                $_POST['tmembers_name']
            );
        }
        if ( array_key_exists( 'tmembers_picture', $_POST ) ) {

            $meta_key = 'tmembers_picture';
            update_post_meta(
                $post_id,
                $meta_key,
                $_POST[$meta_key]
            );
        }

        if ( array_key_exists( 'tmembers_bio', $_POST ) ) {
            update_post_meta(
                $post_id,
                'tmembers_bio',
                $_POST['tmembers_bio']
            );
        }

        if ( array_key_exists( 'tmembers_position', $_POST ) ) {
            update_post_meta(
                $post_id,
                'tmembers_position',
                $_POST['tmembers_position']
            );
        }

    }

    public function tmembers_include_myuploadscript() {
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_enqueue_script( 'tmembers_myuploadscript', TMEMBERS_PLUGIN_URL . '/admin/js/customscript.js', array('jquery'), null, false );
    }

    public function tmembers_image_uploader_field( $name, $value = '') {
        $image = ' button">Upload image';
        $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
        $display = 'none'; // display state ot the "Remove image" button

        if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

            // $image_attributes[0] - image URL
            // $image_attributes[1] - image width
            // $image_attributes[2] - image height

            $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
            $display = 'inline-block';

        }

        return '
            <div>
                <a href="#" class="tmembers_upload_image_button' . $image . '</a>
                <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
                <a href="#" class="tmembers_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
            </div>';
    }

    public function tememers_add_team_members_columns($columns) {
        return array_merge(
                $columns,
                [
                    'tmembers_name' => __("Name"),
                    'tmembers_bio' => __("Bio"),
                    'tmembers_position' => __("Position"),
                ]);
    }

    public function tememers_team_members_column( $column, $post_id ) {
        switch ( $column ) {
            case 'tmembers_name':
                echo get_post_meta( $post_id , 'tmembers_name' , true );
                break;
            case 'tmembers_bio':
                echo get_post_meta( $post_id , 'tmembers_bio' , true );
                break;
            case 'tmembers_position':
                echo get_post_meta( $post_id , 'tmembers_position' , true );
                break;
        }
    }

}