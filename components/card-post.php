<?php
$args = wp_parse_args($args, [
    'img_size' => IMG_SIZE_SM,
    'title_tag' => 'h3'
]);
extract($args);
?>
<a href="<?php the_permalink(); ?>" class="card-post">
    <div class="card-post__img-holder bg-surface ratio-4-3">
        <?= get_core_image(get_post_thumbnail_id(), $img_size, 'card-post__img', true); ?>
    </div>
    <?= "<$title_tag class='card-post__title h6'>" . esc_html(get_the_title()) . "</$title_tag>"; ?>
    <?php get_template_part('components/date'); ?>
</a>