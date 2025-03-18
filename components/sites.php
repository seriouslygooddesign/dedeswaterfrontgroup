<?php
$venues = get_posts([
    'post_type' => 'venue',
    'posts_per_page' => -1,
]);
if (!$venues) return; ?>
<div class="spacer-section-py-half fs-sm">
    <div class="row g-4 row-cols-sm-2 row-cols-lg-4">
        <?php
        foreach ($venues as $post) : setup_postdata($post);
            $args = array(
                'image_id' => get_post_thumbnail_id(),
                'card_link' => get_field('link'),
                'card_link_target' => '_blank',
                'title_extra_class' => 'h6',
                'content' => apply_filters('the_content', get_the_excerpt()),
            ); ?>
            <div class="col-12" data-animate>
                <?php get_template_part('components/card', null, $args); ?>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata() ?>
    </div>
</div>