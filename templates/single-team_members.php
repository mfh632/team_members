<?php
/**
 * The template for displaying all single posts
 */

get_header();

$postIde = get_the_ID();

$name = get_post_meta($postIde, 'tmembers_name', true);
$picture = get_post_meta($postIde, 'tmembers_picture', true);
$bio = get_post_meta($postIde, 'tmembers_bio', true);
$position = get_post_meta($postIde, 'tmembers_position', true);
$pictureSrc = TMEMBERS_PLUGIN_URL . "public/images/member.jpg";
$image_size = 'full';
if ($image_attributes = wp_get_attachment_image_src($picture, $image_size)) {

    // $image_attributes[0] - image URL
    // $image_attributes[1] - image width
    // $image_attributes[2] - image height

    $pictureSrc = $image_attributes[0];
}

?>
    <article id="post-<?php $postIde; ?>" <?php post_class(); ?>>
        <header class="entry-header alignwide" style="margin-bottom: 15px;">
            <?php if ($pictureSrc): ?>
                <img src="<?= $pictureSrc ?>" alt="<?= $name ?>" style="max-width: 75%; display: block; border-radius: 2%; border: 10px solid gray;"/>
            <?php endif; ?>
            <h1 class="entry-title"><?= $name ?></h1>
        </header><!-- .entry-header -->
        <div class="alignwide">
            <p><strong>Designation: </strong><?= $position ?></p>
            <p><strong>BIO: </strong><?= $bio ?></p>
        </div>
    </article>

<?php get_footer(); ?>