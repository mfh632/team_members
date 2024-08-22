<?php
/**
 * The template for displaying all single posts
 */

get_header();

$postIde = get_the_ID();
$image_size = 'full';
$position = get_post_meta($postIde, 'tmembers_position', true);
$pictureSrc = has_post_thumbnail() ? get_the_post_thumbnail_url($post, $image_size) : TMEMBERS_PLUGIN_URL . "public/images/member.jpg";

?>
    <article id="post-<?php $postIde; ?>" <?php post_class(); ?>>
        <header class="entry-header alignwide" style="margin-bottom: 15px;">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <?php if ($pictureSrc): ?>
                <img src="<?= $pictureSrc ?>" alt="<?= get_the_title() ?>" style="max-width: 75%; display: block; border-radius: 2%; border: 10px solid gray;"/>
            <?php endif; ?>
        </header><!-- .entry-header -->
        <div class="alignwide">
            <h3><?= __('Bio:') ?></h3>
            <hr><br>
            <?php  the_content(); ?>

            <p style="margin-top: 10px;"><strong>Designation: </strong><?= $position ?></p>
        </div>
    </article>

<?php get_footer(); ?>