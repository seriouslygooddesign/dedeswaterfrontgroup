<?php
$feed_type_featured_events = get_sub_field('type') === 'featured';

$posts = [];

if ($feed_type_featured_events) {
    $posts_args = [
        'post_type' => WHATS_ON_POST_TYPE_NAME,
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'whats-on-category',
                'field' => 'slug',
                'terms' => 'featured-posts'
            ]
        ]
    ];
    switch_to_blog(1);
    $posts = get_posts($posts_args);
    restore_current_blog();
} else {
    $venues = get_posts([
        'post_type' => 'venue',
        'posts_per_page' => -1,
    ]);

    foreach ($venues as $post) {
        setup_postdata($post);
        $site_id = get_field('related_site_id');
        if (!$site_id) continue;
        $posts[] = [
            'name' => get_the_title(),
            'url' => get_blog_details($site_id)->siteurl . "/" . WHATS_ON_URL_PREFIX,
            'featured_image' => get_core_image(get_post_thumbnail_id(), IMG_SIZE_LG, 'stretch card__img'),
            'logo' => get_core_image(get_field('logo'), IMG_SIZE_SM, 'card__img-logo'),
        ];
        wp_reset_postdata();
    }
}

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
get_template_part('components/block', 'header', ['class' => 'container']);
switch_to_blog(1);
?>
<div class="container" data-animate>
    <div class="layout-stairs">
        <?php
        foreach ($posts as $post) :
            setup_postdata($post);
            if ($feed_type_featured_events) {
                $event_date = ($event_date = esc_html(get_field('event_date'))) ? "<span>" . get_core_icon('calendar', 'icon-inline fs-xs') . $event_date . "</span>" : null;
                $location = ($location = esc_html(get_field('location'))) ? "<span>" . get_core_icon('pin', 'icon-inline fs-xs') . $location . "</span>" : null;
                $content_top = $event_date || $location ? "<div class='fs-sm color-text-primary vstack gap-1'>$event_date$location</div>" : null;
                $content_excerpt = "<p>" . get_the_excerpt() . "</p>";
                $content = "<div class='vstack gap-3'>$content_top$content_excerpt</div>";
                restore_current_blog();
                $card_link = get_permalink();
                switch_to_blog(1);

                $card_args = [
                    'content' => $content,
                    'card_link' => $card_link,
                ];
            } else {
                $title = $post['name'];
                $link = $post['url'];
                $image = $post['featured_image'];
                $logo = $post['logo'];

                $card_args = [
                    'image' => $image . "<div class='stretch curtain'></div>" . $logo,
                    'title' => $title,
                    'content' => '',
                    'card_link' => $link,
                    'card_link_target' => '_blank',
                    'image_holder_class' => 'card__img-holder--restrict'
                ];
            }

            echo "<div class='layout-stairs__item' data-animate='up'>";
            get_template_part('components/card', null, $card_args);
            echo "</div>";
        endforeach;
        wp_reset_postdata(); ?>
    </div>
</div>

<?php
restore_current_blog();
get_template_part('components/block', 'footer', ['class' => 'container']);
get_template_part('components/block', 'end');
