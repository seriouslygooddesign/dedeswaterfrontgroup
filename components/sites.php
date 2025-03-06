<?php
$venues = get_posts([
    'post_type' => 'venue',
    'posts_per_page' => -1,
]);
if (!$venues) return; ?>
<div class="spacer-section-py-half fs-sm">
    <div class="row g-4 row-cols-sm-2 row-cols-lg-4 justify-content-center">
        <?php
        foreach ($venues as $post) : setup_postdata($post);
            $link = [
                'title' => get_the_title(),
                'url' => get_field('link'),
                'target' => '_blank',
            ];
            $args = array(
                'image_id' => get_post_thumbnail_id(),
                'card_link' => $link['url'],
                'title_extra_class' => 'h6',
                'content' => apply_filters('the_content', get_the_excerpt()),
                'footer_content' => null
            ); ?>
            <div class="col-12" data-animate>
                <?php get_template_part('components/card', null, $args); ?>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata() ?>
    </div>
</div>