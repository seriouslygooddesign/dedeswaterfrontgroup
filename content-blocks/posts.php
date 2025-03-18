<?php
$feed_type = get_sub_field('feed_type');
$feed_type_select_posts = $feed_type === 'select_posts';
$feed_type_latest_by_category = $feed_type === 'latest_by_category';
$selected_posts = get_sub_field('posts');
$selected_categories = get_sub_field('categories');

$args = wp_parse_args($args, [
    'post_type' => 'post',
    'posts_per_page' => get_sub_field('posts_per_page') ?: 3,
    'post__in' => $feed_type_select_posts ? $selected_posts : [],
    'taxonomy' => $feed_type_latest_by_category ? 'category' : null,
    'terms' => $feed_type_latest_by_category ? $selected_categories : null,
    'title' => null,
    'card_component_name' => 'card',
    'class' => null,
]);
extract($args);

if (!isset($title)) {
    $title = 'More ' . '<span class="text-offset">' . get_the_title(get_option('page_for_posts')) . '</span>';
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

$block_args = [
    'class' => $class
];
get_template_part('components/block', 'start', $block_args);
?>
<div class="container">
    <?php if (get_sub_field('block_header_show')) : ?>
        <?php get_template_part('components/block', 'header'); ?>
    <?php else : ?>
        <h2><?= wp_kses_post($title); ?></h2>
    <?php endif; ?>

    <div class="layout-stairs">
        <?php
        foreach ($posts as $post) : setup_postdata($post); ?>
            <div class='layout-stairs__item' data-animate='up'>
                <?php get_template_part("components/$card_component_name"); ?>
            </div>
        <?php
        endforeach;
        wp_reset_postdata();
        ?>
    </div>
</div>
<?php
get_template_part('components/block', 'end'); ?>