<?php
$posts = get_posts(
    [
        'post_type' => 'testimonial',
        'posts_per_page' => '-1'
    ]
);

$posts = get_sub_field('type') == 'select' ? get_sub_field('posts') : $posts;
if (!$posts) return;

$block_args = [
    'modifier' => basename(__FILE__, '.php'),
    'class' => 'min-height-full',
    'background' => false
];
get_template_part('components/block', 'start', $block_args);

$swiper_parameters = json_encode([
    "slidesPerView" => "auto",
    "spaceBetween" => 20,
    "loop" => true,
    "effect" => "fade",
    "autoHeight" => true,
]);
?>
<div class="row g-0 min-height-full">
    <div class="col-md-6 pos-rel section-py d-flex has-bg overflow-hidden align-items-center">
        <?php get_template_part('components/background') ?>
        <div class="container-sm" data-animate>
            <?php get_template_part('components/block', 'header'); ?>
        </div>
    </div>
    <div class="col-md-6 pos-rel section-py d-flex align-items-center">
        <div class="stretch bg-light"></div>
        <div class="container-sm" data-animate>
            <div class='swiper swiper--center swiper--off-canvas swiper--layout-row' data-swiper='<?= $swiper_parameters ?>'>
                <div class='swiper-wrapper'>
                    <?php
                    foreach ($posts as $post) : setup_postdata($post);
                        $icon = ($icon = get_core_image(get_post_thumbnail_id(), IMG_SIZE_XS, 'rounded-image')) ? "<div class='col-auto'>$icon</div>" : null;
                        $author = ($title = esc_html(get_the_title())) ? "<div class='col-md'><div class='row g-3 align-items-center uppercase'>$icon<div class='col'>$title</div></div></div>" : null;
                        $venue_link = get_core_link(get_field('link'), 'uppercase', "<div class='col-md'><div class='vstack gap-0 text-right'><span class='text-muted'>Venue: </span>", "</div></div>");

                        $args = [
                            'image_id' => null,
                            'title' => false,
                            'content' => apply_filters('the_content', get_the_content()),
                            'footer_content' => "<div class='row'>$author$venue_link</div>"
                        ];

                        echo "<div class='swiper-slide'>";
                        get_template_part('components/card', null, $args);
                        echo "</div>";
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
                <?php get_template_part('components/slider-controls', null, ['swiper_navigation_class' => 'flex-xl-column']); ?>
            </div>
        </div>
    </div>
</div>

<?php get_template_part('components/block', 'end'); ?>