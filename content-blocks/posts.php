<?php
$feed_type = get_sub_field('feed_type');
$feed_type_select_posts = $feed_type === 'select_posts';
$feed_type_latest_by_category = $feed_type === 'latest_by_category';
$selected_posts = get_sub_field('posts');
$selected_categories = get_sub_field('categories');

$args = wp_parse_args($args, [
    'post_type' => 'post',
    'posts_per_page' => get_sub_field('posts_per_page') ?: 8,
    'post__in' => $feed_type_select_posts ? $selected_posts : [],
    'taxonomy' => $feed_type_latest_by_category ? 'category' : null,
    'terms' => $feed_type_latest_by_category ? $selected_categories : null,
    'title' => null,
    'card_component_name' => 'card',
    'class' => null,
]);
extract($args);

if (!isset($title)) {
    $title = 'Latest ' . get_post_type_object($post_type)->label;
}

$posts_args = [
    'post_type' => $post_type,
    'posts_per_page' => $posts_per_page,
];

if ($post__in) {
    $posts_args['posts_per_page'] = count($post__in);
    $posts_args['post__in'] = $post__in;
    $posts_args['orderby'] = 'post__in';
}

if (is_singular($post_type)) {
    $posts_args['post__not_in'] = [get_the_ID()];
}

if ($taxonomy && $terms) {
    $posts_args['tax_query'] = [
        [
            'taxonomy' => $taxonomy,
            'terms'    => $terms,
            'field'    => 'term_id',
        ]
    ];
}

$posts = get_posts($posts_args);
if (empty($posts)) return;

$total_posts = count($posts);


$desktop_slides_per_view = 4;
$card_component_args = [
    'img_size' => IMG_SIZE_SM
];
if ($total_posts < 4) {
    $desktop_slides_per_view = 3;
    $card_component_args['img_size'] = IMG_SIZE_MD;
}

$overflow_hidden_class = 'overflow-hidden';
$class = $class ? "$class $overflow_hidden_class" : $overflow_hidden_class;
$block_args = [
    'class' => $class
];
get_template_part('components/block', 'start', $block_args);
?>
<div class="container<?= $total_posts > 3 ? "-xl" : ''; ?>">
    <div class="row gx-3 align-items-end">
        <?php if (get_sub_field('block_header_show')) : ?>
            <?php get_template_part('components/block', 'header', ['class' => 'col']); ?>
        <?php else : ?>
            <div class="col" data-animate>
                <h2><?= esc_html($title); ?></h2>
            </div>
        <?php endif; ?>
        <?php
        $post_type_archive_link = get_post_type_archive_link($post_type);
        if ($post_type_archive_link) : ?>
            <div class="col-auto" data-animate>
                <p><a href="<?= esc_url($post_type_archive_link); ?>" class="button">View All</a></p>
            </div>
        <?php endif; ?>
    </div>

    <?php
    $swiper_parameters = json_encode([
        "spaceBetween" => 10,
        "slidesPerView" => 1,
        "breakpoints" => [
            640 => [
                "slidesPerView" => 2,
                "slidesPerGroup" => 2,
            ],
            1024 => [
                "slidesPerView" => $desktop_slides_per_view,
                "slidesPerGroup" => $desktop_slides_per_view,
                "spaceBetween" => 20,
            ]
        ]
    ]);
    ?>
    <div data-animate>
        <div class="swiper swiper--off-canvas" data-swiper='<?= $swiper_parameters; ?>'>
            <div class="swiper-wrapper">
                <?php
                foreach ($posts as $post) : setup_postdata($post); ?>
                    <div class="swiper-slide">
                        <?php get_template_part("components/$card_component_name", null, $card_component_args); ?>
                    </div>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
            <?php get_template_part('components/slider-controls'); ?>
        </div>
    </div>
</div>
<?php
get_template_part('components/block', 'end'); ?>