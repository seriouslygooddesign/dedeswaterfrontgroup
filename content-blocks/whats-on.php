<?php
$site_url = get_site_url();
$current_blog_id = get_current_blog_id();

$feed_type_featured_events = get_sub_field('type') === 'featured';

$sites_with_posts = [];
$site_details = [];

$posts_args = [
    'post_type' => WHATS_ON_POST_TYPE_NAME,
    'posts_per_page' => -1,
];

if ($feed_type_featured_events) {
    $posts_args['tax_query'] = [
        [
            'taxonomy' => 'whats-on-category',
            'field' => 'slug',
            'terms' => 'featured-posts'
        ]
    ];
}

switch_to_blog(1);
$posts = get_posts($posts_args);

if (!$posts) return;

if (!$feed_type_featured_events) {
    foreach ($posts as $post) {
        $list_of_websites = get_field('list_of_websites');
        if ($list_of_websites && is_array($list_of_websites)) {
            $sites_with_posts = array_merge($sites_with_posts, $list_of_websites);
        }
    }

    $sites_with_posts = array_unique($sites_with_posts);

    foreach ($sites_with_posts as $site_id) {
        switch_to_blog($site_id);
        $whats_on_page = get_page_by_path(WHATS_ON_URL_PREFIX);

        if ($whats_on_page) {
            $featured_image_id = get_post_thumbnail_id($whats_on_page->ID);
            $featured_image = get_core_image($featured_image_id, IMG_SIZE_LG, 'stretch card__img');

            $site_details[] = array(
                'name' => get_blog_details($site_id)->blogname,
                'url' => get_blog_details($site_id)->siteurl . "/" . WHATS_ON_URL_PREFIX,
                'featured_image' => $featured_image,
                'logo' => get_core_image(intval(get_theme_mod('custom_logo')), IMG_SIZE_SM, 'card__img-logo'),
            );
        }

        restore_current_blog();
    }
    $posts = $site_details;
}

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
];
get_template_part('components/block', 'start', $block_args);
get_template_part('components/block', 'header', ['class' => 'container']);
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
                    'image' => $image . $logo,
                    'title' => $title,
                    'content' => '',
                    'card_link' => $link,
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
get_template_part('components/block', 'footer', ['class' => 'container']);
get_template_part('components/block', 'end');
restore_current_blog();
