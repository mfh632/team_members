<?php

$isShowSeeAll = get_option('tmembers_is_disable_see_all', '');
$numberOfItem = get_option('tmembers_number_of_item', '') ?? 4;

$posts = get_posts([
    'post_type' => 'team_members',
    'post_status' => 'publish',
    'numberposts' => $numberOfItem,
    'orderby' => 'date',
    'order'    => 'ASC'
]);

?>

<div style="max-width: 1280px; margin: 0 auto; padding: 10px; background: #fff;">
    <div style="display: flex; justify-content: center; gap: 10px; text-align: center;">
        <?php foreach ($posts as $post):?>
            <?php
                $seeAllLink = tmembers_get_team_members_url();
                $postIde = $post->ID;
                $position = get_post_meta($postIde, 'tmembers_position', true);
                $image_size = '200x200';
                $pictureSrc = get_the_post_thumbnail_url($post, $image_size) != false ? get_the_post_thumbnail_url($post, $image_size) : TMEMBERS_PLUGIN_URL . "public/images/member.jpg";
            ?>
            <div style="max-width: 200px; width: 200px; height: auto; background: #eee;">
                <a href="<?= get_permalink($post) ?>" style="text-decoration: none;">
                    <img src="<?= $pictureSrc ?>" style="width: 100%; border-radius: 50%; background: #fff;"/>
                    <h3 style="padding: 5px 0;"><?= $post->post_title ?></h3>
                </a>
                <p>Designation</p>
            </div>
        <?php endforeach;?>
    </div>
    <?php if (!$isShowSeeAll): ?>
        <div style="text-align: center; padding: 10px 0;">
            <a style="padding: 5px;" href="<?= $seeAllLink ?>"><?= __('See All')?></a>
        </div>
    <?php endif; ?>
</div>
