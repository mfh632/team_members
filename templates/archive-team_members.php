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
                $position = get_post_meta($postIde, 'tmembers_position', true);
                $pictureSrc = TMEMBERS_PLUGIN_URL . "public/images/member.jpg";
                $image_size = '200x200';
            ?>
            <div class="grid-item">
                <a href="<?= get_permalink() ?>">
                    <?php if (has_post_thumbnail()): ?>
                    <?=  get_the_post_thumbnail( $post, $image_size ) ?>
                    <?php else: ?>
                        <img src="<?= $pictureSrc?>" class="tmembers-img" alt="<?= get_the_title() ?>">
                    <?php endif; ?>
                    <h2><?= get_the_title() ?></h2>
                </a>
                <p><?= $position ?></p>
            </div>
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

get_footer();
