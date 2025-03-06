<?php
add_shortcode('phone', function ($atts, $content) {
    $phone = get_field('phone', 'option');
    $a = shortcode_atts(array(
        'wrap' => 'true',
        'link' => $phone['link'] ?? '',
        'label' => $phone['label'] ?? '',
    ), $atts);
    extract($a);
    if (!$link) return;
    $wrap = $wrap === 'true' ? true : false;
    $label = $content ?: $label;
    ob_start();
    get_template_part('components/icon-label', null, ['icon' => 'phone', 'label' => $label, 'url' => "tel:$link", 'wrap' => $wrap]);
    return ob_get_clean();
});

add_shortcode('email', function ($atts, $content) {
    $email = get_field('email', 'option');
    $a = shortcode_atts(array(
        'wrap' => 'true',
        'link' => $email['link'] ?? '',
        'label' => $email['label'] ?? '',
    ), $atts);
    extract($a);
    if (!$link) return;
    $wrap = $wrap === 'true' ? true : false;
    $label = $content ?: $label;
    ob_start();
    get_template_part('components/icon-label', null, ['icon' => 'email', 'label' => $label, 'url' => "mailto:" . antispambot($link, 1), 'wrap' => $wrap, 'target_blank' => true]);
    return ob_get_clean();
});

add_shortcode('address', function ($atts, $content) {
    $address = get_field('address', 'option');
    $a = shortcode_atts(array(
        'wrap' => 'true',
        'link' => $address['link'] ?? '',
        'label' => $address['label'] ?? '',
    ), $atts);
    extract($a);
    if (!$link) return;
    $wrap = $wrap === 'true' ? true : false;
    $label = $content ?: $label;
    ob_start();
    get_template_part('components/icon-label', null, ['icon' => 'pin', 'label' => $label, 'url' => $link, 'wrap' => $wrap, 'target_blank' => true, 'noopener_noreferrer' => true]);
    return ob_get_clean();
});

add_shortcode('social_icons', function () {
    ob_start();
    get_template_part('components/social-icons');
    return ob_get_clean();
});

add_shortcode('cta_link', function () {
    $link = get_field('cta_link', 'option');
    if ($link) {
        $link_url = esc_url($link['url']);
        $link_title = esc_html($link['title']);
        $link_target = $link['target'] ? esc_attr($link['target']) : '_self';
        return "<a class='button' href='$link_url' target='$link_target'>$link_title</a>";
    }
});

add_shortcode('testimonials', function () {

    $sites = get_sites();
    if (!$sites && count($sites) >= 1) {
        return;
    }

    $output = $contents = '';

    $swiper_parameters = json_encode([
        "slidesPerView" => "auto",
        "spaceBetween" => 20,
        "loop" => true,
        "effect" => "fade",
        "autoHeight" => true,
    ]);

    foreach ($sites as $site) {
        $id = $site->blog_id;

        if ($id === get_current_blog_id()) {
            continue;
        }

        $site_name = get_blog_details($id)->blogname;
        $site_url = get_blog_details($id)->domain;

        switch_to_blog($id);

        $posts = get_posts(
            [
                'post_type' => 'testimonial',
                'posts_per_page' => '-1'
            ]
        );

        if ($posts) {
            foreach ($posts as $post) : setup_postdata($post);
                $args = [
                    'title' => false,
                    'content' => apply_filters('the_content', get_the_content()),
                    'footer_content' => [
                        'left' => "<div class='hstack gap-3 align-items-center uppercase'>" . get_core_image(get_post_thumbnail_id($post), IMG_SIZE_XS, 'rounded-image') . get_the_title($post) . "</div>",
                        'right' => "<div class='vstack gap-0 text-right'><span class='text-muted'>Venue: </span>" . get_core_link(['title' => $site_name, 'url' => $site_url, 'target' => '_blank'], 'uppercase') . "</div>",
                    ]
                ];

                $contents .= "<div class='swiper-slide'>";
                ob_start();
                get_template_part('components/card', null, $args);
                $contents .= ob_get_clean();
                $contents .= "</div>";

            endforeach;
            wp_reset_postdata();
        }

        restore_current_blog();
    }
    if ($contents) {
        $output .= "<div class='swiper swiper--center swiper--off-canvas swiper--layout-row' data-swiper='$swiper_parameters'>";
        $output .= "<div class='swiper-wrapper'>$contents</div>";
        ob_start();
        get_template_part('components/slider-controls', null, ['swiper_navigation_class' => 'flex-xl-column']);
        $output .= ob_get_clean();
        $output .= "</div>";
    }
    return $output;
});
