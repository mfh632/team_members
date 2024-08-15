<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
?>

<?php if ( have_posts() ) : ?>

    <header class="page-header alignwide">
        <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
        <?php if ( $description ) : ?>
            <div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
        <?php endif; ?>
    </header><!-- .page-header -->


    <div class="grid-container">
        <?php while ( have_posts() ) : ?>
            <?php
                the_post();
                $postIde = get_the_ID();

                $name = get_post_meta($postIde, 'tmembers_name', true);
                $picture = get_post_meta($postIde, 'tmembers_picture', true);
                $bio = get_post_meta($postIde, 'tmembers_bio', true);
                $position = get_post_meta($postIde, 'tmembers_position', true);
                $pictureSrc = TMEMBERS_PLUGIN_URL . "public/images/member.jpg";
                $image_size = '200x200';
                if ($image_attributes = wp_get_attachment_image_src($picture, $image_size)) {
                    // $image_attributes[0] - image URL
                    // $image_attributes[1] - image width
                    // $image_attributes[2] - image height
                    $pictureSrc = $image_attributes[0];
                }
            ?>
            <div class="grid-item">
                <a href="<?= get_permalink() ?>">
                    <?php if ($pictureSrc): ?>
                    <img src="<?= $pictureSrc?>" class="tmembers-img" alt="<?= $name ?>">
                    <?php endif; ?>
                    <h3><?= $name ?></h3>
                </a>
                <p><?= $position ?></p>
            </div>
            <?php // get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) ); ?>
        <?php endwhile; ?>


    </div>

    <!-- Pagination Goes Here -->
    <div class="row">
        <div class="small-12 columns">
            <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => 'Previous',
                    'next_text' => 'Next',
                ));
            ?>
        </div>
    </div>

<?php else : ?>
    <?php echo "<h2>Sorry, no posts matched your criteria.</h2>"; ?>
<?php endif; ?>

    <style>
        .grid-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-auto-columns: minmax(20rem, auto);
            grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
            background-color: #fff;
            padding: 10px;
            gap:10px;
        }

        .grid-item {
            background-color: #ddd;
            padding: 10px;
            font-size: 30px;
            text-align: center;
        }
        .grid-item a {
            text-decoration: none;
            display: block;
        }
        .grid-item a:hover {
            opacity: 70%;
        }

        .tmembers-img {
            border-radius: 50%;
            width: 100%;
            display: block;
            background: #fff;
        }
    </style>
<?php

echo do_shortcode('[team_members]');

get_footer();
